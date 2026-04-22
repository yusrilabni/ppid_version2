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
            
            // Pengambilan Berita RSS dengan deteksi gambar lebih cerdas
            try {
                $response = Http::timeout(5)->get('https://humas.sinjaikab.go.id/v1/rss-widget/index.php');
                if ($response->successful()) {
                    $rss_data = $response->json();
                    if (is_array($rss_data)) {
                        foreach (array_slice($rss_data, 0, 10) as $item) {
                            // Cari gambar di beberapa kolom kemungkinan
                            $img = $item['thumbnail'] ?? $item['image'] ?? $item['enclosure'] ?? '';
                            $rss_items[] = [
                                'title' => $item['title'] ?? '',
                                'link' => $item['link'] ?? '#',
                                'pubDate' => $item['pubDate'] ?? '',
                                'image' => $img,
                            ];
                        }
                    }
                }
            } catch (\Exception $e) {}

            return response()->json([
                'success' => true,
                'data' => [
                    'sliders' => Slider::latest()->take(5)->get(),
                    'latest_informasi' => Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
                        ->orderBy('tanggal_upload', 'desc')
                        ->take(10)
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
                        'total_permohonan' => PermohonanInformasi::count(),
                        'total_survey' => SurveyResponse::count(),
                        'tingkat_kepuasan' => round((PermohonanInformasi::whereNotNull('rating')->avg('rating') / 5) * 100) ?: 0,
                        'rata_rata_respon' => round(PermohonanInformasi::where('status_permohonan', 'selesai')->get()->avg(function($p){
                            return max(1, Carbon::parse($p->updated_at)->diffInDays(Carbon::parse($p->created_at)));
                        })) ?: 1,
                        'tingkat_penyelesaian' => PermohonanInformasi::count() > 0 ? round((PermohonanInformasi::where('status_permohonan', 'selesai')->count() / PermohonanInformasi::count()) * 100) : 0,
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
