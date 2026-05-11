<?php

namespace App\Observers;

use App\Models\Berita;
use Illuminate\Support\Facades\Cache;

class BeritaObserver
{
    /**
     * Handle the Berita "saved" event.
     * Saved handles both "created" and "updated" events.
     */
    public function saved(Berita $berita): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Berita "deleted" event.
     */
    public function deleted(Berita $berita): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Berita "restored" event.
     */
    public function restored(Berita $berita): void
    {
        $this->clearCache();
    }

    /**
     * Clear all related caches.
     */
    protected function clearCache(): void
    {
        Cache::forget('berita_home_latest');
        Cache::forget('berita_all_paginated');
        // If using cache tags (requires Redis/Memcached)
        // Cache::tags(['berita'])->flush();
    }
}
