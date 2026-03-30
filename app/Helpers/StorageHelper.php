<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class StorageHelper
{
    /**
     * Mendapatkan URL file dengan prioritas:
     * 1. v2/storage (Upload Production)
     * 2. ppid_version2/storage (Copy Local)
     * 3. public_html/media (Fallback Media)
     */
    public static function getUrl($path)
    {
        if (!$path) return asset('assets/img/default.png');

        // Gunakan path absolut server nantinya
        // Di simulasi ini menggunakan path relatif dari folder aplikasi
        $p1 = base_path('../public_html/v2/storage/' . $path);
        $p2 = storage_path('app/public/' . $path);
        $p3 = base_path('../public_html/media/' . $path);

        // PRIORITAS 1: v2/storage
        if (File::exists($p1)) {
            return asset('storage/' . $path);
        }

        // PRIORITAS 2: ppid_version2/storage
        if (File::exists($p2)) {
            return asset('storage_local/' . $path);
        }

        // PRIORITAS 3: public_html/media
        if (File::exists($p3)) {
            return asset('media/' . $path);
        }

        return asset('assets/img/not-found.png');
    }
}
