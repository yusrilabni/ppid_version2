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
use Carbon\Carbon;

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
                $response = Http::timeout(5)->get('https://humas.sinjaikab.go.id/v1/rss-widget/index.php');
                if ($response->successful()) {
                    $rss_data = $response->json();
                    if (is_array($rss_data)) {
                        foreach (array_slice($rss_data, 0, 10) as $item) {
                            $rss_items[] = [
                                'title' => $item['title'] ?? '',
                                'link' => $item['link'] ?? '#',
                                'pubDate' => $item['pubDate'] ?? '',
                                'image' => $item['thumbnail'] ?? '',
                            ];
                        }
                    }
                }
            } catch (\Exception $e) {}

            // 3. Galeri
            $galeri = Galeri::latest()->take(10)->get() ?: [];

            // 4. Statistik & Laporan Kinerja (FULL SYNC WEB)
            $allPermohonans = PermohonanInformasi::all();
            $totalPermohonans = $allPermohonans->count();
            $averageRating = PermohonanInformasi::whereNotNull('rating')->avg('rating') ?: 0;
            
            // Hitung Rata-rata Waktu Respon
            $completedPermohonans = $allPermohonans->where('status_permohonan', 'selesai');
            $completedCount = $completedPermohonans->count();
            $totalDays = 0;
            foreach ($completedPermohonans as $p) {
                $totalDays += max(1, Carbon::parse($p->updated_at)->diffInDays(Carbon::parse($p->created_at)));
            }
            $avgResponse = $completedCount > 0 ? round($totalDays / $completedCount) : 0;

            $unitData = GeneralHelper::getUnitData();
            
            $stats = [
                'total_informasi' => Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])->count(),
                'total_permohonan' => $totalPermohonans,
                'total_survey' => SurveyResponse::count(),
                'tingkat_kepuasan' => round(($averageRating / 5) * 100),
                'rata_rata_respon' => $avgResponse ?: 1,
                'tingkat_penyelesaian' => $totalPermohonans > 0 ? round(($completedCount / $totalPermohonans) * 100) : 0,
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
                        'time' => Carbon::parse($t->updated_at)->diffForHumans()
                    ];
                });

            // 6. Dokumen Terbaru
            $latestInformasi = Informasi::whereIn('status', ['AKTIF', 'BERLAKU'])
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
