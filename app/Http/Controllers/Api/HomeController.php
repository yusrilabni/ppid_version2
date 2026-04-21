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
            
            // API hanya menyediakan data, Android yang menentukan limitasi tampilan
            return response()->json([
                'success' => true,
                'data' => [
                    'sliders' => Slider::latest()->take(10)->get(),
                    'latest_informasi' => Informasi::whereIn('status', ['AKTIF', 'BERLAKU'])
                        ->orderBy('tanggal_upload', 'desc')
                        ->take(20) // Kirim lebih banyak, Android yang slice(0,5)
                        ->get()
                        ->map(function($item) use ($unitData) {
                            $unit = $unitData->get((string)$item->unit_id);
                            $item->organization_name = $unit['unit_nama'] ?? 'Unit Kerja';
                            return $item;
                        }),
                    'news' => $this->getRSSNews(),
                    'gallery' => Galeri::latest()->take(15)->get(),
                    'statistics' => [
                        'total_informasi' => Informasi::whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])->count(),
                        'total_permohonan' => PermohonanInformasi::count(),
                        'total_survey' => SurveyResponse::count(),
                        'tingkat_kepuasan' => round((PermohonanInformasi::whereNotNull('rating')->avg('rating') / 5) * 100),
                        'rata_rata_respon' => round(PermohonanInformasi::where('status_permohonan', 'selesai')->get()->avg(function($p){
                            return max(1, Carbon::parse($p->updated_at)->diffInDays(Carbon::parse($p->created_at)));
                        })) ?: 1,
                        'tingkat_penyelesaian' => PermohonanInformasi::count() > 0 ? round((PermohonanInformasi::where('status_permohonan', 'selesai')->count() / PermohonanInformasi::count()) * 100) : 0,
                    ],
                    'ticker' => PermohonanInformasi::whereNotNull('rating')->orderBy('updated_at', 'desc')->take(10)->get()->map(function($t){
                        return [
                            'nama_pemohon' => $t->nama_pemohon,
                            'rating' => $t->rating,
                            'text' => $t->detail_informasi ? substr(strip_tags($t->detail_informasi), 0, 80) : 'Layanan Memuaskan',
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

    private function getRSSNews() {
        try {
            $response = Http::timeout(5)->get('https://humas.sinjaikab.go.id/v1/rss-widget/index.php');
            return $response->successful() ? array_slice($response->json(), 0, 10) : [];
        } catch (\Exception $e) { return []; }
    }
}
