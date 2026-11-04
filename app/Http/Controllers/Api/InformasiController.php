<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class InformasiController extends Controller
{
    /**
     * Resolusi nama organisasi/unit kerja secara akurat.
     */
    private function resolveOrganizationName($unitId, $unitData = null): string
    {
        $uId = (string)($unitId ?? '');
        if ($uId === '' || $uId === '0' || strtolower($uId) === 'kabupaten') {
            return 'Pemerintah Kabupaten Sinjai';
        }

        if ($unitData && $unitData->has($uId)) {
            $unit = $unitData->get($uId);
            if (!empty($unit['unit_nama'])) {
                return $unit['unit_nama'];
            }
        }

        $org = \App\Models\Organization::where('remote_id', $uId)
            ->orWhere('id', $uId)
            ->first();

        if ($org && !empty($org->name)) {
            return $org->name;
        }

        return 'Pemerintah Kabupaten Sinjai';
    }

    /**
     * Ambil daftar informasi publik (DIP) dengan paginasi lengkap.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $isSuperadmin = ($user && $user->role === 'superadmin');
        $userUnitId = $user ? ($user->unit_id ?? null) : null;
        $userScope = $isSuperadmin ? 'superadmin' : ($userUnitId ? 'unit_' . $userUnitId : 'guest');

        $cacheKey = 'all_informasi_' . $userScope . '_' . md5(json_encode($request->all()));
        
        $informasi = Cache::remember($cacheKey, 60, function () use ($request, $user, $isSuperadmin, $userUnitId) {
            $query = Informasi::with('official.position');

            // Hak akses visibilitas & status dokumen
            if ($isSuperadmin) {
                // Superadmin: melihat semua dokumen publik dan private
            } elseif ($user && $userUnitId) {
                // Admin OPD: melihat semua dokumen publik + dokumen private milik unitnya
                $query->where(function ($q) use ($userUnitId) {
                    $q->where(function ($pubQ) {
                        $pubQ->where(function ($vq) {
                            $vq->where('visibility', 'public')
                               ->orWhereNull('visibility');
                        })->where(function ($sq) {
                            $sq->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP', 'published'])
                               ->orWhere('published', 1);
                        });
                    })->orWhere('unit_id', $userUnitId);
                });
            } else {
                // Pengunjung publik umum: HANYA dokumen public dan berstatus published/aktif/berlaku
                $query->where(function ($vq) {
                    $vq->where('visibility', 'public')
                       ->orWhereNull('visibility');
                })->where(function ($sq) {
                    $sq->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP', 'published'])
                       ->orWhere('published', 1);
                });
            }

            // Pencarian Umum
            $searchTerm = $request->get('search', $request->get('q'));
            if ($searchTerm) {
                $words = explode(' ', $searchTerm);
                $query->where(function ($q) use ($searchTerm, $words) {
                    $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('category', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhereHas('official.organization', function($org) use ($searchTerm) {
                          $org->where('name', 'LIKE', '%' . $searchTerm . '%');
                      });
                    foreach ($words as $word) {
                        $q->orWhere('title', 'LIKE', '%' . $word . '%');
                    }
                });
            }

            // Filter Kategori
            if ($request->has('category') && $request->get('category') !== 'Semua') {
                $query->where('category', $request->get('category'));
            }

            // Filter Unit (Dinas)
            if ($request->has('unit_id') && $request->filled('unit_id')) {
                $query->where('unit_id', $request->get('unit_id'));
            }

            // Filter Status
            if ($request->has('status') && $request->get('status') !== 'Semua') {
                $query->where('status', $request->get('status'));
            }

            // Filter Tanggal
            if ($request->has('date_from') && $request->get('date_from') != '') {
                $query->whereDate('tanggal_upload', '>=', $request->get('date_from'));
            }
            if ($request->has('date_to') && $request->get('date_to') != '') {
                $query->whereDate('tanggal_upload', '<=', $request->get('date_to'));
            }
            if ($request->has('date')) {
                $query->whereDate('tanggal_upload', $request->get('date'));
            }

            // Sorting
            $sort = $request->get('sort', 'created_at_desc'); // default
            if ($request->has('sort_created') && $request->get('sort_created') == 1) {
                $sort = 'created_at_desc'; // Legacy support
            }

            switch ($sort) {
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'tanggal_upload_asc':
                    $query->orderBy('tanggal_upload', 'asc');
                    break;
                case 'tanggal_upload_desc':
                    $query->orderBy('tanggal_upload', 'desc');
                    break;
                case 'created_at_desc':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $perPage = $request->get('per_page', 10);
            $informasi = $query->paginate($perPage);

            $unitData = GeneralHelper::getUnitData();
            
            $informasi->getCollection()->transform(function ($item) use ($unitData) {
                $item->organization_name = $this->resolveOrganizationName($item->unit_id, $unitData);
                // ... rest of mapping
                if ($item->file) {
                    $item->file_url = url('storage/' . $item->file);
                }
                return $item;
            });
            
            return $informasi;
        });

        try {

            return response()->json([
                'success' => true,
                'data' => $informasi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ambil detail informasi berdasarkan slug atau ID.
     */
    public function show($slug, Request $request): JsonResponse
    {
        try {
            $item = Informasi::with(['user', 'official.position'])
                ->where('slug', $slug)
                ->orWhere('id', $slug)
                ->firstOrFail();

            // Pengecekan visibilitas private
            $user = $request->user();
            $isSuperadmin = ($user && $user->role === 'superadmin');
            $userUnitId = $user ? ($user->unit_id ?? null) : null;
            $isPrivate = ($item->visibility === 'private' || $item->status === 'draft' || $item->published == 0);

            if ($isPrivate && !$isSuperadmin && (!$userUnitId || (string)$userUnitId !== (string)$item->unit_id)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Dokumen ini bersifat internal/private.'
                ], 403);
            }

            $item->increment('views_count');

            if ($item->informasi_pemkab_id) {
                \DB::table('informasi_pemkabs')->where('id', $item->informasi_pemkab_id)->update(['views_count' => $item->views_count]);
            }

            $unitData = GeneralHelper::getUnitData();
            $item->organization_name = $this->resolveOrganizationName($item->unit_id, $unitData);
            
            if ($item->file) {
                $item->file_url = url('storage/' . $item->file);
            }

            // Fallback nama pengunggah jika user_id NULL
            if (!$item->user) {
                $item->uploader_name = 'Admin PPID ' . $item->organization_name;
            } else {
                $item->uploader_name = $item->user->name;
            }

            // Get related informasi
            $item->related_informasis = Informasi::where('category', $item->category)
                ->where('unit_id', $item->unit_id)
                ->where('id', '!=', $item->id)
                ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $item
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Dokumen tidak ditemukan'
            ], 404);
        }
    }
}
