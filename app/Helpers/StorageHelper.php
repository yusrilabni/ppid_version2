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

        // Path Absolut cPanel
        $p1 = '/home/ppidkab/public_html/v2/storage/' . $path;
        $p2 = '/home/ppidkab/ppid_version2/storage/app/public/' . $path;

        // PRIORITAS 1: v2/storage (File Baru)
        // Gunakan file_exists karena ini path absolut server
        if (file_exists($p1)) {
            return asset('storage/' . $path);
        }

        // PRIORITAS 2: ppid_version2/storage (File Lama)
        if (file_exists($p2)) {
            return asset('storage_local/' . $path);
        }

        // Jika tidak ketemu, coba asumsikan itu path relatif dari storage/app/public
        return asset('storage_local/' . $path);
    }
}
