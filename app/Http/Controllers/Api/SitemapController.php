<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Informasi;
use App\Models\Berita;
use App\Models\Official;
use App\Models\InformasiPemkab;

class SitemapController extends Controller
{
    public function index(): JsonResponse
    {
        $urls = [];
        $baseUrl = config('app.frontend_url', 'https://ppid.sinjaikab.go.id');

        // 1. Informasi Publik
        try {
            $informasis = Informasi::select('slug', 'updated_at')
                ->whereIn('status', ['AKTIF', 'BERLAKU', 'ARSIP'])
                ->get();
            foreach ($informasis as $item) {
                if (!$item->slug) continue;
                $urls[] = [
                    'loc' => $baseUrl . '/informasi/detail/' . $item->slug,
                    'lastmod' => $item->updated_at ? $item->updated_at->toIso8601String() : now()->toIso8601String(),
                    'changefreq' => 'monthly',
                    'priority' => 0.8
                ];
            }
        } catch (\Exception $e) {}

        // 2. Berita
        try {
            if (class_exists(Berita::class)) {
                $beritas = Berita::select('slug', 'updated_at')->where('status', 'PUBLISHED')->get();
                foreach ($beritas as $item) {
                    if (!$item->slug) continue;
                    $urls[] = [
                        'loc' => $baseUrl . '/berita/' . $item->slug,
                        'lastmod' => $item->updated_at ? $item->updated_at->toIso8601String() : now()->toIso8601String(),
                        'changefreq' => 'weekly',
                        'priority' => 0.9
                    ];
                }
            }
        } catch (\Exception $e) {}

        // 3. Profil Pejabat/OPD
        try {
            if (class_exists(Official::class)) {
                $officials = Official::select('slug', 'updated_at')->where('is_active', true)->get();
                foreach ($officials as $item) {
                    if (!$item->slug) continue;
                    $urls[] = [
                        'loc' => $baseUrl . '/profil/' . $item->slug,
                        'lastmod' => $item->updated_at ? $item->updated_at->toIso8601String() : now()->toIso8601String(),
                        'changefreq' => 'monthly',
                        'priority' => 0.7
                    ];
                }
            }
        } catch (\Exception $e) {}

        // 4. Informasi Pemkab
        try {
            if (class_exists(InformasiPemkab::class)) {
                $infPemkab = InformasiPemkab::select('slug', 'updated_at')->where('is_published', true)->get();
                foreach ($infPemkab as $item) {
                    if (!$item->slug) continue;
                    $urls[] = [
                        'loc' => $baseUrl . '/transparansi/informasi-pemkab/' . $item->slug,
                        'lastmod' => $item->updated_at ? $item->updated_at->toIso8601String() : now()->toIso8601String(),
                        'changefreq' => 'monthly',
                        'priority' => 0.7
                    ];
                }
            }
        } catch (\Exception $e) {}

        return response()->json($urls);
    }
}
