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

            // HIRARKI MENDETAIL: Urutkan berdasarkan aturan protokol pemerintah
            $officials = $query->get()->map(function($item) {
                // Pastikan URL Foto Absolut dan Bersih
                if ($item->photo) {
                    $item->photo_url = url('storage/' . $item->photo);
                } else {
                    $item->photo_url = null;
                }
                
                $pos = strtolower($item->position->name ?? '');
                $org = strtolower($item->organization->name ?? '');

                // Penentuan Bobot Hirarki (Makin Kecil Makin Atas)
                if (str_contains($pos, 'bupati') && !str_contains($pos, 'wakil')) $item->h_rank = 1;
                elseif (str_contains($pos, 'wakil bupati')) $item->h_rank = 2;
                elseif (str_contains($pos, 'sekretaris daerah') || $pos == 'sekda') $item->h_rank = 3;
                elseif (str_contains($pos, 'staf ahli')) $item->h_rank = 4;
                elseif (str_contains($pos, 'asisten i') || str_contains($pos, 'asisten 1')) $item->h_rank = 5;
                elseif (str_contains($pos, 'asisten ii') || str_contains($pos, 'asisten 2')) $item->h_rank = 6;
                elseif (str_contains($pos, 'asisten iii') || str_contains($pos, 'asisten 3')) $item->h_rank = 7;
                elseif (str_contains($pos, 'inspektur')) $item->h_rank = 8;
                elseif (str_contains($pos, 'kepala dinas') || str_contains($pos, 'kepala badan') || str_contains($pos, 'kaban') || str_contains($pos, 'kadis')) $item->h_rank = 9;
                elseif (str_contains($pos, 'camat')) $item->h_rank = 10;
                elseif (str_contains($pos, 'lurah')) $item->h_rank = 11;
                elseif (str_contains($pos, 'kepala desa') || str_contains($pos, 'kades')) $item->h_rank = 12;
                else $item->h_rank = 99;

                return $item;
            })->sortBy('h_rank')->values();

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
