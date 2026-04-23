<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Official;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfficialController extends Controller
{
    /**
     * Get list of all officials (Bupati, OPD, Kades/Lurah)
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Official::with(['position', 'organization'])
                ->where('status', 'active');

            // Optional: Filter by type (bupati, opd, desa)
            if ($request->has('type')) {
                $type = $request->get('type');
                $query->whereHas('organization', function ($q) use ($type) {
                    if ($type === 'kecamatan') {
                        $q->where('type', 'kecamatan');
                    } elseif ($type === 'desa') {
                        $q->where('name', 'LIKE', 'Desa%');
                    } elseif ($type === 'kelurahan') {
                        $q->where('name', 'LIKE', 'Kelurahan%');
                    } else {
                        $q->where('type', 'opd');
                    }
                });
            }

            // HIRARKI: Urutkan berdasarkan Jabatan (Bupati -> Wakil -> Sekda -> dst)
            $officials = $query->get()->map(function($item) {
                // Tambahkan FULL URL untuk foto agar muncul di Android
                $item->photo_url = $item->photo ? url('storage/' . $item->photo) : null;
                
                // Berikan bobot hirarki (makin kecil makin atas)
                $name = strtolower($item->position->name);
                if (str_contains($name, 'bupati') && !str_contains($name, 'wakil')) $item->hierarchy = 1;
                elseif (str_contains($name, 'wakil bupati')) $item->hierarchy = 2;
                elseif (str_contains($name, 'sekretaris daerah') || str_contains($name, 'sekda')) $item->hierarchy = 3;
                elseif (str_contains($name, 'asisten')) $item->hierarchy = 4;
                elseif (str_contains($name, 'kepala dinas') || str_contains($name, 'kepala badan')) $item->hierarchy = 5;
                else $item->hierarchy = 99;

                return $item;
            })->sortBy('hierarchy')->values();

            return response()->json([
                'success' => true,
                'message' => 'Daftar Pimpinan berhasil diambil',
                'data' => $officials
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar pimpinan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detailed profile of a specific official
     */
    public function show($slug): JsonResponse
    {
        try {
            $official = Official::with([
                'position', 
                'organization', 
                'careerHistories', 
                'educations', 
                'awards', 
                'trainingHistories',
                'organizationalHistories',
                'lhkpns'
            ])
            ->where('slug', $slug)
            ->firstOrFail();

            return response()->json([
                'success' => true,
                'message' => 'Profil Lengkap Pimpinan berhasil diambil',
                'data' => $official
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Profil tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil profil pimpinan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
