<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class StorageController extends Controller
{
    /**
     * Serve a file from prioritized storage locations.
     * This acts as a fallback when the web server cannot find the file in public/storage.
     *
     * @param string $path
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show($path)
    {
        // Define prioritized paths from .env or defaults
        // Pastikan path ini sesuai dengan cPanel
        $priorities = [
            env('STORAGE_PRIORITY_1', '/home/ppidkab/public_html/v2/storage'),
            env('STORAGE_PRIORITY_2', base_path('storage/app/public')),
            // Tambahan fallback jika folder ppid_version2 ada di lokasi lain
            '/home/ppidkab/ppid_version2/storage/app/public',
        ];

        foreach ($priorities as $basePath) {
            $fullPath = rtrim($basePath, '/') . '/' . ltrim($path, '/');

            if (File::exists($fullPath) && File::isFile($fullPath)) {
                return response()->file($fullPath);
            }
        }

        abort(404, "File tidak ditemukan di semua lokasi penyimpanan: " . $path);
    }
}
