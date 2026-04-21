<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Informasi;
use App\Models\Official;
use App\Models\Laporan;
use App\Models\ProfilPpid;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            // 1. Ambil Sliders (Pastikan tidak error jika kosong)
            $sliders = Slider::latest()->take(5)->get() ?: [];

            // 2. Ambil Statistik
            $unitData = GeneralHelper::getUnitData();
            $stats = [
                'total_informasi' => Informasi::whereIn('status', ['AKTIF', 'BERLAKU'])->count() ?: 0,
                'total_pejabat' => Official::where('status', 'active')->count() ?: 0,
                'total_opd' => $unitData ? count($unitData) : 0,
                'total_laporan' => Laporan::where('published', true)->count() ?: 0,
            ];

            // 3. Ambil Informasi Terbaru
            $latestInformasi = Informasi::whereIn('status', ['AKTIF', 'BERLAKU'])
                ->orderBy('tanggal_upload', 'desc')
                ->take(5)
                ->get();
            
            $formattedLatest = [];
            if ($latestInformasi) {
                $formattedLatest = $latestInformasi->map(function($item) use ($unitData) {
                    $unit = $unitData ? $unitData->get((string)$item->unit_id) : null;
                    $item->organization_name = $unit['unit_nama'] ?? 'Unit Tidak Terdaftar';
                    return $item;
                });
            }

            // 4. Data Profil PPID
            $profil = ProfilPpid::first() ?: (object)[
                'visi' => 'Visi belum diatur',
                'misi' => 'Misi belum diatur',
                'maklumat' => 'Maklumat belum diatur'
            ];

            return response()->json([
                'success' => true,
                'message' => 'Data Beranda berhasil disinkronkan',
                'data' => [
                    'sliders' => $sliders,
                    'statistics' => $stats,
                    'latest_informasi' => $formattedLatest,
                    'profil_ppid' => $profil
                ]
            ]);

        } catch (\Exception $e) {
            // Jika error, kirim pesan JSON yang rapi (bukan HTML error page)
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data beranda',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
