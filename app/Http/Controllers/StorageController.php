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
     * @return \Illuminate\Http\Response
     */
    public function show($path)
    {
        // Define prioritized paths from .env or defaults
        $priorities = [
            env('STORAGE_PRIORITY_1', '/home/ppidkab/public_html/v2/storage'),
            env('STORAGE_PRIORITY_2', base_path('storage/app/public')),
        ];

        foreach ($priorities as $basePath) {
            $fullPath = rtrim($basePath, '/') . '/' . $path;

            if (File::exists($fullPath) && File::isFile($fullPath)) {
                $file = File::get($fullPath);
                $type = File::mimeType($fullPath);

                $response = Response::make($file, 200);
                $response->header("Content-Type", $type);

                return $response;
            }
        }

        abort(404, "File not found in any prioritized storage.");
    }
}
