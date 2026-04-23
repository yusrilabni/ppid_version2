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

                // 1. Logika Penamaan Jabatan Dinamis (Agar lebih akurat seperti di Web)
                if (str_contains($pos, 'kepala opd') || str_contains($pos, 'pimpinan')) {
                    if (str_contains($org, 'dinas')) $item->display_position = 'Kepala ' . ucwords($org);
                    elseif (str_contains($org, 'badan')) $item->display_position = 'Kepala ' . ucwords($org);
                    elseif (str_contains($org, 'inspektorat')) $item->display_position = 'Inspektur Kabupaten Sinjai';
                    elseif (str_contains($org, 'sekretariat dprd')) $item->display_position = 'Sekretaris DPRD';
                    elseif (str_contains($org, 'kecamatan')) $item->display_position = 'Camat ' . str_ireplace('Kecamatan ', '', ucwords($org));
                    else $item->display_position = $item->position->name;
                } else {
                    $item->display_position = $item->position->name;
                }

                // 2. Penentuan Bobot Hirarki & Kategori (Sesuai Aturan Eselon)
                if (str_contains($pos, 'bupati') && !str_contains($pos, 'wakil')) {
                    $item->h_rank = 1;
                    $item->category = 'Pimpinan Daerah';
                } elseif (str_contains($pos, 'wakil bupati')) {
                    $item->h_rank = 2;
                    $item->category = 'Pimpinan Daerah';
                } elseif (str_contains($pos, 'sekretaris daerah') || $pos == 'sekda') {
                    $item->h_rank = 3;
                    $item->category = 'Pimpinan Daerah';
                } 
                // ESELON II: Staf Ahli, Asisten, Inspektur, Kadis, Kaban, Sekwan, Kepala OPD (bukan camat)
                elseif (
                    str_contains($pos, 'staf ahli') || 
                    str_contains($pos, 'asisten') || 
                    str_contains($pos, 'inspektur') || 
                    str_contains($pos, 'kadis') || 
                    str_contains($pos, 'kaban') || 
                    str_contains($org, 'dinas') || 
                    str_contains($org, 'badan') || 
                    (str_contains($pos, 'kepala opd') && !str_contains($org, 'kecamatan'))
                ) {
                    $item->h_rank = 4;
                    $item->category = 'Eselon II';
                } 
                // ESELON III: Camat
                elseif (str_contains($pos, 'camat') || str_contains($org, 'kecamatan')) {
                    $item->h_rank = 5;
                    $item->category = 'Eselon III';
                } 
                elseif (str_contains($pos, 'lurah') || str_contains($org, 'kelurahan')) {
                    $item->h_rank = 6;
                    $item->category = 'Lurah';
                } elseif (str_contains($pos, 'kades') || str_contains($pos, 'kepala desa') || str_contains($org, 'desa')) {
                    $item->h_rank = 7;
                    $item->category = 'Kepala Desa';
                } else {
                    $item->h_rank = 99;
                    $item->category = 'Pejabat Lainnya';
                }

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
                'lhkpns',
                'children' // Tambahkan relasi anak
            ])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

            // Pastikan URL Foto Absolut
            if ($official->photo) {
                $official->photo_url = url('storage/' . $official->photo);
            } else {
                $official->photo_url = null;
            }

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
