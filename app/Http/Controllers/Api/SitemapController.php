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

        $xmlStr = '<?xml version="1.0" encoding="UTF-8"?>';
        $xmlStr .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        $staticUrls = [
            ['loc' => $baseUrl . '/', 'changefreq' => 'daily', 'priority' => 1.0],
            ['loc' => $baseUrl . '/search', 'changefreq' => 'weekly', 'priority' => 0.8],
            ['loc' => $baseUrl . '/kontak', 'changefreq' => 'monthly', 'priority' => 0.8],
            ['loc' => $baseUrl . '/statistik', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/profil/bupati', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/profil/wakil-bupati', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/profil/sekretaris-daerah', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/profil/pejabat-daerah', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/profil/unit-lokal', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/profil/ppid', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/profil/tentang-opd', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/informasi/berkala', 'changefreq' => 'weekly', 'priority' => 0.9],
            ['loc' => $baseUrl . '/informasi/setiap-saat', 'changefreq' => 'weekly', 'priority' => 0.9],
            ['loc' => $baseUrl . '/informasi/serta-merta', 'changefreq' => 'weekly', 'priority' => 0.9],
            ['loc' => $baseUrl . '/informasi/dikecualikan', 'changefreq' => 'weekly', 'priority' => 0.9],
            ['loc' => $baseUrl . '/dip', 'changefreq' => 'weekly', 'priority' => 0.8],
            ['loc' => $baseUrl . '/dipunit', 'changefreq' => 'weekly', 'priority' => 0.8],
            ['loc' => $baseUrl . '/standar-layanan', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/maklumat-layanan', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/sop-layanan', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/laporan', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/galeri', 'changefreq' => 'weekly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/regulasi', 'changefreq' => 'monthly', 'priority' => 0.7],
            ['loc' => $baseUrl . '/lhkpn', 'changefreq' => 'monthly', 'priority' => 0.6],
            ['loc' => $baseUrl . '/pbj', 'changefreq' => 'monthly', 'priority' => 0.6],
        ];
        
        $allUrls = array_merge($staticUrls, $urls);
        
        foreach ($allUrls as $url) {
            $xmlStr .= '<url>';
            $xmlStr .= '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
            if (isset($url['lastmod'])) $xmlStr .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            if (isset($url['changefreq'])) $xmlStr .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            if (isset($url['priority'])) $xmlStr .= '<priority>' . $url['priority'] . '</priority>';
            $xmlStr .= '</url>';
        }
        
        $xmlStr .= '</urlset>';
        
        return response($xmlStr)->header('Content-Type', 'text/xml');
    }
}
