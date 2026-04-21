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
        try {
            // 1. Sliders
            $sliders = Slider::latest()->take(5)->get() ?: [];

            // 2. Berita RSS
            $rss_items = [];
            try {
                $response = Http::timeout(10)->get('https://humas.sinjaikab.go.id/v1/rss-widget/index.php');
                if ($response->successful()) {
                    $rss_data = $response->json();
                    if (is_array($rss_data)) {
                        foreach (array_slice($rss_data, 0, 10) as $item) {
                            $rss_items[] = [
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
            $galeri = Galeri::latest()->take(10)->get() ?: [];

            // 4. Statistik Lengkap (MENGIKUTI WEB)
            $unitData = GeneralHelper::getUnitData();
            $avgRating = PermohonanInformasi::whereNotNull('rating')->avg('rating') ?: 0;
            
            $stats = [
                'total_informasi' => Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])->count(),
                'total_permohonan' => PermohonanInformasi::count(),
                'total_survey' => SurveyResponse::count(), // Tambah IKM
                'tingkat_kepuasan' => round(($avgRating / 5) * 100),
                'total_opd' => count($unitData),
                'total_pejabat' => Official::where('status', 'active')->count(),
            ];

            // 5. Ticker Rating (Ulasan Pemohon)
            $latestRatings = PermohonanInformasi::whereNotNull('rating')
                ->whereNotNull('rating_comment')
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->get()
                ->map(function($t) {
                    return [
                        'nama_pemohon' => $t->nama_pemohon,
                        'rating' => $t->rating,
                        'text' => $t->rating_comment,
                        'time' => $t->updated_at->diffForHumans()
                    ];
                });

            // 6. Dokumen Terbaru
            $latestInformasi = Informasi::with('organization')->whereIn('status', ['AKTIF', 'BERLAKU'])
                ->orderBy('tanggal_upload', 'desc')
                ->take(8)
                ->get()
                ->map(function($item) use ($unitData) {
                    $unit = $unitData->get((string)$item->unit_id);
                    $item->organization_name = $unit['unit_nama'] ?? 'Unit Kerja';
                    return $item;
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'sliders' => $sliders,
                    'latest_informasi' => $latestInformasi,
                    'news' => $rss_items,
                    'gallery' => $galeri,
                    'statistics' => $stats,
                    'ticker' => $latestRatings,
                    'contact' => [
                        'alamat' => 'Jl. Persatuan Raya No. 5, Sinjai',
                        'email' => 'ppid@sinjaikab.go.id',
                        'telepon' => '08123456789'
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
