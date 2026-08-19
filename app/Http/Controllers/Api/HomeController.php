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
    public function rssNews(): JsonResponse
    {
        try {
            $rss_items = \Illuminate\Support\Facades\Cache::remember('rss_news', 3600, function () {
                $items = [];
                try {
                    $response = Http::timeout(5)->get('https://humas.sinjaikab.go.id/v1/rss');
                    if ($response->successful()) {
                        $xml = simplexml_load_string($response->body());
                        if ($xml && isset($xml->channel->item)) {
                            $count = 0;
                            foreach ($xml->channel->item as $item) {
                                if ($count >= 10) break;
                                
                                $img = '';
                                if (isset($item->enclosure)) {
                                    $attributes = $item->enclosure->attributes();
                                    if (isset($attributes['url'])) {
                                        $img = (string) $attributes['url'];
                                    }
                                }
                                
                                $items[] = [
                                    'title' => (string) $item->title,
                                    'link' => (string) $item->link,
                                    'pubDate' => isset($item->pubDate) ? Carbon::parse((string) $item->pubDate)->translatedFormat('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
                                    'image' => $img,
                                    'views' => rand(150, 600)
                                ];
                                $count++;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Gagal fetch RSS Humas: ' . $e->getMessage());
                }
                return $items;
            });

            return response()->json([
                'success' => true,
                'data' => $rss_items
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil berita'
            ], 500);
        }
    }

    public function index(): JsonResponse
    {
        try {
            $dbData = \Illuminate\Support\Facades\Cache::get('all_home');
            
            if (empty($dbData)) {
                $lock = \Illuminate\Support\Facades\Cache::lock('build_all_home_lock', 30);
                if ($lock->get()) {
                    try {
                        $unitData = GeneralHelper::getUnitData();
                        
                        $dbData = [
                            'sliders' => Slider::where('active', true)->orderBy('order', 'asc')->get(),
                            'latest_informasi' => Informasi::with('user')->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])->orderBy('tanggal_upload', 'desc')->take(16)->get()->map(function($item) use ($unitData) {
                                $unit = $unitData->get((string)$item->unit_id);
                                $item->organization_name = $unit['unit_nama'] ?? 'Unit Kerja';
                                return $item;
                            }),
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
                        ];
                        \Illuminate\Support\Facades\Cache::forever('all_home', $dbData);
                    } finally {
                        $lock->release();
                    }
                } else {
                    // Block and wait if another process is building the cache
                    $dbData = \Illuminate\Support\Facades\Cache::get('all_home');
                    if (empty($dbData)) {
                        sleep(2);
                        $dbData = \Illuminate\Support\Facades\Cache::get('all_home') ?? [];
                    }
                }
            }

            $dbData['contact'] = [
                'alamat' => 'Jl. Persatuan Raya No. 5, Sinjai',
                'email' => 'ppid@sinjaikab.go.id',
                'telepon' => '08123456789'
            ];

            return response()->json([
                'success' => true,
                'data' => $dbData
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
