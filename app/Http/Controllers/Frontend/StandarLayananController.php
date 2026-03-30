<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\StandarLayanan;
use App\Models\SubStandarLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StandarLayananController extends Controller
{
                public function showBySlug($slug)
                {
                    $menuConfig = config('menu');
                    $standarLayananMenu = collect($menuConfig)->firstWhere('title', 'Standar Layanan');
                    $staticChildren = collect($standarLayananMenu['children'] ?? []);
            
                    $foundLayanan = null;
                    $categoryIcon = 'fas fa-file-alt';
            
                    $specialSlugs = [
                        'maklumat' => 'Maklumat Pelayanan',
                        'tugas-wewenang' => 'Tugas, Wewenang & Tanggung Jawab',
                        'mekanisme-biaya' => 'Mekanisme & Biaya',
                    ];
            
                    if (array_key_exists($slug, $specialSlugs)) {
                        $foundLayanan = StandarLayanan::where('title', $specialSlugs[$slug])->first();
                    } else {
                        foreach (StandarLayanan::all() as $item) {
                            $itemSlug = Str::slug($item->title);
                            if ($itemSlug === $slug) {
                                $foundLayanan = $item;
                                break;
                            }
                        }
                    }
            
                    if ($foundLayanan) {
                        $matchingStaticChild = $staticChildren->firstWhere('title', $foundLayanan->title);
                        if ($matchingStaticChild) {
                            $categoryIcon = 'fas fa-' . ($matchingStaticChild['icon'] ?? 'file-alt');
                        }
                    }
            
                                if (!$foundLayanan) {
                                    abort(404, 'Kategori tidak ditemukan.');
                                }
                    
                                                        if ($slug === 'tugas-wewenang' || $slug === 'maklumat' || $slug === 'mekanisme-biaya') {
                                                            $activeSubLayanan = SubStandarLayanan::where('standar_layanan_id', $foundLayanan->id)
                                                                                                 ->where('status_tampil', 'aktif')
                                                                                                 ->first();
                                                    
                                                            if ($activeSubLayanan) {
                                                                return redirect()->route('frontend.standar-layanan.file-detail', $activeSubLayanan);
                                                            }
                                                        }                                $standarLayanan = $foundLayanan;            
                    if (array_key_exists($slug, $specialSlugs)) {
                        $informasiItems = \App\Models\Informasi::where('status', 'aktif')
                            ->whereHas('subStandarLayanan.standarLayanan', function ($query) use ($specialSlugs, $slug) {
                                $query->where('title', $specialSlugs[$slug]);
                            })
                            ->with('subStandarLayanan')
                            ->latest()
                            ->get();
            
                        $subLayanans = $informasiItems->map->subStandarLayanan->filter();
            
                        if ($subLayanans->isNotEmpty()) {
                            $allImages = $subLayanans->every(function ($subLayanan) {
                                if (!$subLayanan || !$subLayanan->file) return false;
                                $fileExtension = strtolower(pathinfo($subLayanan->file, PATHINFO_EXTENSION));
                                return in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']);
                            });
            
                            if ($allImages) {
                                return view('frontend.standar-layanan.gallery', compact('subLayanans', 'standarLayanan', 'categoryIcon'));
                            }
                        }
                        
                        $standarLayanan->setRelation('subStandarLayanans', $subLayanans);
                    } else {
                         $foundLayanan->load(['subStandarLayanans' => function ($query) {
                            $query->latest();
                        }]);
                    }
            
                    return view('frontend.standar-layanan.show', compact('standarLayanan', 'categoryIcon'));
                }    /**
     * Display details of a specific SubStandarLayanan file.
     */
    public function showFileDetail(SubStandarLayanan $subStandarLayanan)
    {
        // Increment views_count when file detail page is viewed
        $subStandarLayanan->increment('views_count');

        // Log file details for debugging
        \Log::info('SubStandarLayanan File Details:', [
            'slug' => $subStandarLayanan->slug,
            'title' => $subStandarLayanan->title,
            'file_type' => $subStandarLayanan->file_type,
            'file' => $subStandarLayanan->file,
            'url' => $subStandarLayanan->url,
        ]);

        // Eager load parent category title for breadcrumbs
        $subStandarLayanan->load('standarLayanan'); 

        // Get category icon for breadcrumbs
        $menuConfig = config('menu');
        $standarLayananMenu = collect($menuConfig)->firstWhere('title', 'Standar Layanan');
        $staticChildren = collect($standarLayananMenu['children'] ?? []);
        $categoryIcon = 'fas fa-file-alt'; // Default icon for category in breadcrumbs

        if ($subStandarLayanan->standarLayanan) {
            $matchingStaticChild = $staticChildren->firstWhere('title', $subStandarLayanan->standarLayanan->title);
            if ($matchingStaticChild) {
                $categoryIcon = 'fas fa-' . ($matchingStaticChild['icon'] ?? 'file-alt');
            }
        }

        return view('frontend.standar-layanan.file-detail', compact('subStandarLayanan', 'categoryIcon'));
    }

    /**
     * Handle file download.
     */
    public function download(SubStandarLayanan $subStandarLayanan)
    {
        // Increment download_count
        $subStandarLayanan->increment('download_count');

        $filePath = $subStandarLayanan->file;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath);
    }

    /**
     * Handle redirecting to an external URL.
     */
    public function visitUrl(SubStandarLayanan $subStandarLayanan)
    {
        // Increment download_count as requested by user for external link clicks
        $subStandarLayanan->increment('download_count'); 

        if (!$subStandarLayanan->url) {
            abort(404, 'URL tidak ditemukan.');
        }

        return redirect()->away($subStandarLayanan->url);
    }
}
