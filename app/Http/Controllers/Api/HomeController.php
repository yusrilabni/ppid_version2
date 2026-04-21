<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Informasi;
use App\Models\Official;
use App\Models\Laporan;
use App\Models\Galeri;
use App\Models\PermohonanInformasi;
use App\Models\SurveyResponse;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        // Inisialisasi data kosong agar jika ada yang gagal, yang lain tetap jalan
        $data = [
            'sliders' => [],
            'news' => [],
            'gallery' => [],
            'statistics' => [
                'total_informasi' => 0,
                'total_permohonan' => 0,
                'total_survey' => 0,
                'tingkat_kepuasan' => 0,
                'total_opd' => 0,
                'total_pejabat' => 0,
            ],
            'ticker' => [],
            'latest_informasi' => [],
            'contact' => [
                'alamat' => 'Jl. Persatuan Raya No. 5, Sinjai',
                'email' => 'ppid@sinjaikab.go.id',
                'telepon' => '08123456789'
            ]
        ];

        try {
            // 1. Sliders
            $data['sliders'] = Slider::latest()->take(5)->get();

            // 2. Berita RSS
            try {
                $response = Http::timeout(5)->get('https://humas.sinjaikab.go.id/v1/rss-widget/index.php');
                if ($response->successful()) {
                    $rss_data = $response->json();
                    if (is_array($rss_data)) {
                        foreach (array_slice($rss_data, 0, 10) as $item) {
                            $data['news'][] = [
                                'title' => $item['title'] ?? '',
                                'link' => $item['link'] ?? '#',
                                'pubDate' => $item['pubDate'] ?? '',
                                'description' => strip_tags($item['description'] ?? ''),
                                'image' => $item['thumbnail'] ?? '',
                            ];
                        }
                    }
                }
            } catch (\Exception $e) {}

            // 3. Galeri
            $data['gallery'] = Galeri::latest()->take(10)->get();

            // 4. Statistik (Mencakup status ARSIP agar jadi 129)
            try {
                $unitData = GeneralHelper::getUnitData();
                $avgRating = PermohonanInformasi::whereNotNull('rating')->avg('rating') ?: 0;
                
                $data['statistics'] = [
                    'total_informasi' => Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])->count(),
                    'total_permohonan' => PermohonanInformasi::count(),
                    'total_survey' => SurveyResponse::count(),
                    'tingkat_kepuasan' => round(($avgRating / 5) * 100),
                    'total_opd' => $unitData ? count($unitData) : 0,
                    'total_pejabat' => Official::where('status', 'active')->count(),
                ];
            } catch (\Exception $e) {}

            // 5. Ticker Rating
            try {
                $data['ticker'] = PermohonanInformasi::whereNotNull('rating')
                    ->orderBy('updated_at', 'desc')
                    ->take(10)
                    ->get()
                    ->map(function($t) {
                        return [
                            'nama_pemohon' => $t->nama_pemohon,
                            'rating' => $t->rating,
                            'text' => $t->detail_informasi ? substr(strip_tags($t->detail_informasi), 0, 50) . '...' : 'Layanan Memuaskan',
                            'time' => $t->updated_at->diffForHumans()
                        ];
                    });
            } catch (\Exception $e) {}

            // 6. Dokumen Terbaru
            try {
                $unitData = GeneralHelper::getUnitData();
                $data['latest_informasi'] = Informasi::whereIn('status', ['AKTIF', 'BERLAKU'])
                    ->orderBy('tanggal_upload', 'desc')
                    ->take(8)
                    ->get()
                    ->map(function($item) use ($unitData) {
                        $unit = $unitData ? $unitData->get((string)$item->unit_id) : null;
                        $item->organization_name = $unit['unit_nama'] ?? 'Unit Kerja';
                        return $item;
                    });
            } catch (\Exception $e) {}

            return response()->json([
                'success' => true,
                'message' => 'Data Beranda Berhasil Diambil',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            // Error Global: Tetap kirim JSON success:false jangan HTML
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
