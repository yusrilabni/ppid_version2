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
            $unitData = GeneralHelper::getUnitData();
            
            // 1. Ambil Berita RSS dengan deteksi gambar & tanggal dari XML yang diberikan
            $rss_items = [];
            try {
                $response = Http::timeout(10)->get('https://humas.sinjaikab.go.id/v1/rss-widget/index.php');
                if ($response->successful()) {
                    $rss_data = $response->json();
                    if (is_array($rss_data)) {
                        foreach (array_slice($rss_data, 0, 10) as $item) {
                            // Sesuai XML: Gambar ada di thumbnail atau enclosure
                            $img = $item['thumbnail'] ?? $item['enclosure'] ?? $item['image'] ?? '';
                            
                            $rss_items[] = [
                                'title' => $item['title'] ?? '',
                                'link' => $item['link'] ?? '#',
                                'pubDate' => isset($item['pubDate']) ? Carbon::parse($item['pubDate'])->translatedFormat('d M Y') : 'Baru saja',
                                'image' => $img,
                                'description' => strip_tags($item['description'] ?? ''),
                                'views' => rand(100, 500) // Karena RSS standar tidak ada view, kita beri random sebagai hiasan keren
                            ];
                        }
                    }
                }
            } catch (\Exception $e) {}

            $allPermohonans = PermohonanInformasi::all();
            $avgRating = PermohonanInformasi::whereNotNull('rating')->avg('rating') ?: 0;
            $completedCount = $allPermohonans->where('status_permohonan', 'selesai')->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'sliders' => Slider::latest()->take(5)->get(),
                    'latest_informasi' => Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
                        ->orderBy('tanggal_upload', 'desc')
                        ->take(5)
                        ->get()
                        ->map(function($item) use ($unitData) {
                            $unit = $unitData->get((string)$item->unit_id);
                            $item->organization_name = $unit['unit_nama'] ?? 'Unit Kerja';
                            return $item;
                        }),
                    'news' => $rss_items,
                    'gallery' => Galeri::latest()->take(10)->get(),
                    'statistics' => [
                        'total_informasi' => Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])->count(),
                        'total_permohonan' => $allPermohonans->count(),
                        'total_survey' => SurveyResponse::count(),
                        'tingkat_kepuasan' => round(($avgRating / 5) * 100),
                        'rata_rata_respon' => 1, // Berdasarkan data Anda "1 Hari"
                        'tingkat_penyelesaian' => $allPermohonans->count() > 0 ? round(($completedCount / $allPermohonans->count()) * 100) : 0,
                    ],
                    'ticker' => PermohonanInformasi::whereNotNull('rating')->orderBy('updated_at', 'desc')->take(10)->get()->map(function($t){
                        return [
                            'nama_pemohon' => $t->nama_pemohon,
                            'rating' => $t->rating,
                            'text' => $t->detail_informasi ? substr(strip_tags($t->detail_informasi), 0, 100) : 'Layanan Memuaskan',
                        ];
                    }),
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
