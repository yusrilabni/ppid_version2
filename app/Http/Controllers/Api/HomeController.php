<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Informasi;
use App\Models\Official;
use App\Models\Laporan;
use App\Models\Galeri;
use App\Models\Contact;
use App\Helpers\GeneralHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            // 1. Ambil Sliders
            $sliders = Slider::latest()->take(5)->get() ?: [];

            // 2. Ambil Berita dari RSS Humas Sinjai
            $api_url = 'https://humas.sinjaikab.go.id/v1/rss-widget/index.php';
            $rss_items = [];
            try {
                $response = Http::get($api_url);
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
            } catch (\Exception $e) {
                \Log::error('API Error: RSS fetch failed: ' . $e->getMessage());
            }

            // 3. Ambil Galeri
            $galeri = Galeri::latest()->take(8)->get();

            // 4. Ambil Statistik
            $unitData = GeneralHelper::getUnitData();
            $stats = [
                'total_informasi' => Informasi::whereIn('status', ['AKTIF', 'BERLAKU'])->count() ?: 0,
                'total_pejabat' => Official::where('status', 'active')->count() ?: 0,
                'total_opd' => $unitData ? count($unitData) : 0,
                'total_laporan' => Laporan::where('published', true)->count() ?: 0,
            ];

            // 5. Ambil Kontak & Alamat
            $contact = [
                'alamat' => 'Jl. Persatuan Raya No. 5, Sinjai',
                'email' => 'ppid@sinjaikab.go.id',
                'telepon' => '08123456789',
                'website' => 'https://ppidkab.sinjaikab.go.id'
            ];

            return response()->json([
                'success' => true,
                'message' => 'Data Beranda Android berhasil diperbarui',
                'data' => [
                    'sliders' => $sliders,
                    'news' => $rss_items,
                    'gallery' => $galeri,
                    'statistics' => $stats,
                    'contact' => $contact
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data beranda',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
