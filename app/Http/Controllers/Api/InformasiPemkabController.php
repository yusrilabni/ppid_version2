<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InformasiPemkab;

class InformasiPemkabController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $isSuperadmin = ($user && $user->role === 'superadmin');
        $userUnitId = $user ? ($user->unit_id ?? null) : null;
        $orgId = null;
        if ($userUnitId) {
            $org = \App\Models\Organization::where('remote_id', (string)$userUnitId)->first();
            $orgId = $org ? $org->id : null;
        }

        $query = InformasiPemkab::with(['user', 'organization']);

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('jenis_dokumen')) {
            $query->where('jenis_dokumen', 'LIKE', '%' . $request->jenis_dokumen . '%');
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Hak akses visibilitas dan status:
        if ($isSuperadmin) {
            // Super Admin melihat semua dokumen (publik & private)
        } elseif ($user && ($userUnitId || $orgId)) {
            // Admin OPD melihat semua dokumen publik + dokumen private milik unitnya
            $query->where(function ($q) use ($userUnitId, $orgId) {
                $q->where(function ($pubQ) {
                    $pubQ->where('visibility', 'public')
                         ->where(function ($sq) {
                             $sq->where('status', 'published')
                                ->orWhere(function ($ssq) {
                                    $ssq->where('status', 'scheduled')
                                        ->where('published_at', '<=', now());
                                });
                         });
                })->orWhere(function ($privQ) use ($userUnitId, $orgId) {
                    if ($orgId) {
                        $privQ->where('unit_id', $orgId);
                    }
                    if ($userUnitId) {
                        $privQ->orWhere('unit_id', $userUnitId);
                    }
                });
            });
        } else {
            // Publik umum: HANYA dokumen public dan published
            $query->where('visibility', 'public')
                  ->where(function ($sq) {
                      $sq->where('status', 'published')
                         ->orWhere(function ($ssq) {
                             $ssq->where('status', 'scheduled')
                                 ->where('published_at', '<=', now());
                         });
                  });
        }

        $perPage = $request->get('per_page', 10);
        $data = $query->orderByRaw('COALESCE(published_at, created_at) DESC')->paginate($perPage);
        $kategori_jenis = InformasiPemkab::KATEGORI_JENIS_DOKUMEN;

        return response()->json([
            'data' => $data,
            'kategori_jenis' => $kategori_jenis
        ]);
    }

    public function show($slug, Request $request)
    {
        $informasi_pemkab = InformasiPemkab::with(['user', 'organization', 'informasi'])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $user = $request->user();
        $isSuperadmin = ($user && $user->role === 'superadmin');
        $userUnitId = $user ? ($user->unit_id ?? null) : null;
        $orgId = null;
        if ($userUnitId) {
            $org = \App\Models\Organization::where('remote_id', (string)$userUnitId)->first();
            $orgId = $org ? $org->id : null;
        }

        $isPrivate = ($informasi_pemkab->visibility === 'private' || $informasi_pemkab->status === 'draft');
        if ($isPrivate && !$isSuperadmin) {
            $isOwner = ($orgId && (int)$informasi_pemkab->unit_id === (int)$orgId) || ($userUnitId && (string)$informasi_pemkab->unit_id === (string)$userUnitId);
            if (!$isOwner) {
                abort(403, 'Dokumen ini bersifat internal/private.');
            }
        }

        if (!$isPrivate) {
            if ($informasi_pemkab->status !== 'published' && $informasi_pemkab->status !== 'scheduled') {
                abort(404);
            }
            if ($informasi_pemkab->status === 'scheduled' && $informasi_pemkab->published_at > now()) {
                abort(404);
            }
        }

        $informasi_pemkab->increment('views_count');

        if ($informasi_pemkab->informasi) {
            \DB::table('informasis')->where('id', $informasi_pemkab->informasi->id)->update(['views_count' => $informasi_pemkab->views_count]);
        }

        return response()->json($informasi_pemkab);
    }
}
