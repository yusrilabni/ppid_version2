<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class StorageHelper
{
    /**
     * Mendapatkan URL file dengan prioritas:
     * 1. v2/storage (Upload Production)
     * 2. ppid_version2/storage (Copy Local)
     */
    public static function getUrl($path)
    {
        if (!$path) return asset('assets/img/default.png');

        $p1 = base_path('../public_html/v2/storage/' . $path);
        $p2 = storage_path('app/public/' . $path);

        // PRIORITAS 1: v2/storage
        if (File::exists($p1)) {
            return asset('storage/' . $path);
        }

        // PRIORITAS 2: ppid_version2/storage
        if (File::exists($p2)) {
            return asset('storage_local/' . $path);
        }

        return asset('assets/img/not-found.png');
    }
}
