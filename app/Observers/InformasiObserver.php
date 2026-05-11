<?php

namespace App\Observers;

use App\Models\Informasi;
use Illuminate\Support\Facades\Cache;

class InformasiObserver
{
    /**
     * Handle the Informasi "saved" event.
     */
    public function saved(Informasi $informasi): void
    {
        $this->clearCache($informasi);
    }

    /**
     * Handle the Informasi "deleted" event.
     */
    public function deleted(Informasi $informasi): void
    {
        $this->clearCache($informasi);
    }

    /**
     * Clear all related caches.
     */
    protected function clearCache(Informasi $informasi): void
    {
        Cache::forget('informasi_latest_home');
        Cache::forget('informasi_detail_' . $informasi->id);
        Cache::forget('informasi_detail_slug_' . $informasi->slug);
        
        if ($informasi->category) {
            $categorySlug = \Str::slug($informasi->category);
            Cache::forget('informasi_category_' . $categorySlug);
        }
    }
}
