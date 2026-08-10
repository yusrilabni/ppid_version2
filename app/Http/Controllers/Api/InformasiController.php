<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    /**
     * Ambil daftar informasi publik (DIP) dengan paginasi lengkap.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Informasi::with('official.position')
                ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP']);

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
            if ($request->has('unit_id') && $request->get('unit_id') !== '') {
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
            if ($request->get('sort_created', 1) == 1) {
                // Urutkan berdasarkan waktu upload/edit terbaru (created_at) seperti di Version 2
                $query->orderBy('created_at', 'desc');
            } else {
                $sort = $request->get('sort', 'tanggal_upload_desc');
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
                    default:
                        $query->orderBy('tanggal_upload', 'desc');
                        break;
                }
            }

            $perPage = $request->get('per_page', 10);
            $informasi = $query->paginate($perPage);

            $unitData = GeneralHelper::getUnitData();
            
            $informasi->getCollection()->transform(function ($item) use ($unitData) {
                $unit = $unitData->get((string)$item->unit_id);
                $item->organization_name = $unit['unit_nama'] ?? 'Unit Tidak Terdaftar';
                // ... rest of mapping
                if ($item->file) {
                    $item->file_url = url('storage/' . $item->file);
                }
                return $item;
            });

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
    public function show($slug): JsonResponse
    {
        try {
            $item = Informasi::with(['user', 'official.position'])
                ->where('slug', $slug)
                ->orWhere('id', $slug)
                ->firstOrFail();

            $item->increment('views_count');

            $unitData = GeneralHelper::getUnitData();
            $unit = $unitData->get((string)$item->unit_id);
            $item->organization_name = $unit['unit_nama'] ?? 'Unit Tidak Terdaftar';
            
            if ($item->file) {
                $item->file_url = url('storage/' . $item->file);
            }

            // Fallback nama pengunggah jika user_id NULL
            if (!$item->user) {
                $item->uploader_name = 'Admin PPID ' . $item->organization_name;
            } else {
                $item->uploader_name = $item->user->name;
            }

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
