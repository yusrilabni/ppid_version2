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
        // Sanitasi path untuk mencegah Path Traversal
        if (str_contains($path, '..') || str_starts_with($path, '/') || str_starts_with($path, '\\')) {
            abort(403, 'Akses ditolak: Path tidak valid.');
        }

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
                $lastModified = File::lastModified($fullPath);
                $etag = md5($fullPath . $lastModified);

                // Check if browser already has the file
                if (request()->header('If-None-Match') == $etag) {
                    return response()->make('', 304);
                }

                return response()->file($fullPath, [
                    'Cache-Control' => 'public, max-age=31536000, immutable',
                    'Expires' => gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000),
                    'ETag' => $etag,
                    'Last-Modified' => gmdate('D, d M Y H:i:s \G\M\T', $lastModified),
                    'Pragma' => 'cache',
                ]);
            }
        }

        // Log path detail hanya ke server log (tidak tampil ke publik)
        \Illuminate\Support\Facades\Log::warning('StorageController: File not found in any storage location.', [
            'requested_path' => $path,
            'ip' => request()->ip(),
        ]);

        abort(404, 'File tidak ditemukan.');
    }
}
