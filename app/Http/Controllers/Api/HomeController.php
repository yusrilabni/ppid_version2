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
            $rss_items = [];
            
            try {
                $response = Http::timeout(10)->get('https://humas.sinjaikab.go.id/v1/rss-widget/index.php');
                if ($response->successful()) {
                    $rss_data = $response->json();
                    if (is_array($rss_data)) {
                        foreach (array_slice($rss_data, 0, 10) as $item) {
                            // FIX: Deteksi Gambar jika berupa Array (Enclosure/Thumbnail)
                            $img = $item['thumbnail'] ?? $item['enclosure'] ?? $item['image'] ?? '';
                            if (is_array($img) && isset($img['url'])) {
                                $img = $img['url'];
                            } elseif (is_array($img) && isset($img[0])) {
                                $img = $img[0];
                            }

                            $rss_items[] = [
                                'title' => $item['title'] ?? '',
                                'link' => $item['link'] ?? '#',
                                'pubDate' => isset($item['pubDate']) ? Carbon::parse($item['pubDate'])->translatedFormat('d M Y') : 'Terbaru',
                                'image' => (string)$img, // Pastikan jadi String URL
                                'views' => rand(150, 600)
                            ];
                        }
                    }
                }
            } catch (\Exception $e) {}

            return response()->json([
                'success' => true,
                'data' => [
                    'sliders' => Slider::where('active', true)->orderBy('order', 'asc')->get(),
                    'latest_informasi' => Informasi::with('user')->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])->orderBy('tanggal_upload', 'desc')->take(16)->get()->map(function($item) use ($unitData) {
                        $unit = $unitData->get((string)$item->unit_id);
                        $item->organization_name = $unit['unit_nama'] ?? 'Unit Kerja';
                        return $item;
                    }),
                    'news' => $rss_items,
                    'gallery' => Galeri::orderBy('is_pinned', 'desc')->orderBy('created_at', 'desc')->take(8)->get(),
                    'statistics' => [
                        'total_informasi' => Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])->count(),
                        'total_permohonan' => PermohonanInformasi::count(),
                        'total_survey' => SurveyResponse::count(),
                        'tingkat_kepuasan' => round((PermohonanInformasi::whereNotNull('rating')->avg('rating') / 5) * 100) ?: 0,
                        'rata_rata_respon' => 1,
                        'tingkat_penyelesaian' => PermohonanInformasi::count() > 0 ? round((PermohonanInformasi::where('status_permohonan', 'selesai')->count() / PermohonanInformasi::count()) * 100) : 0,
                    ],
                    'ticker' => PermohonanInformasi::whereNotNull('rating')->orderBy('updated_at', 'desc')->take(10)->get()->map(function($t){
                        return [
                            'nama_pemohon' => $t->nama_pemohon,
                            'rating' => $t->rating,
                            'text' => $t->detail_informasi ? preg_replace('/\s+/', ' ', trim(strip_tags($t->detail_informasi))) : 'Layanan Memuaskan',
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
