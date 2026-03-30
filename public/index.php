<?php

/**
 * DIRECT STORAGE FALLBACK (SINJAI PPID)
 * Bypass routing Laravel jika request adalah file storage yang tidak ada di public_html.
 */
$uri = $_SERVER['REQUEST_URI'] ?? '';
// Jika mengandung /storage/
if (preg_match('/\/storage\/(.+)$/', $uri, $matches)) {
    // Ambil path setelah /storage/ (buang query string jika ada)
    $filePath = explode('?', $matches[1])[0];
    
    // Prioritas Lokasi File:
    // 1. Relatif terhadap folder aplikasi ppid_version2
    // 2. Path absolut cPanel
    $priorities = [
        __DIR__ . '/../storage/app/public/' . $filePath,
        '/home/ppidkab/ppid_version2/storage/app/public/' . $filePath
    ];

    foreach ($priorities as $fullPath) {
        if (file_exists($fullPath) && is_file($fullPath)) {
            $mime = 'image/png'; // Default
            if (function_exists('mime_content_type')) {
                $mime = @mime_content_type($fullPath) ?: $mime;
            }
            header("Content-Type: $mime");
            header("Content-Length: " . filesize($fullPath));
            readfile($fullPath);
            exit;
        }
    }
}

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Tentukan path ke folder aplikasi ppid_version2
$appPath = __DIR__.'/..';

// 1. Cek Maintenance Mode
if (file_exists($maintenance = $appPath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 2. Register Autoloader
require $appPath.'/vendor/autoload.php';

// 3. Bootstrap Laravel
$app = require_once $appPath.'/bootstrap/app.php';

// 4. Handle Request
$app->handleRequest(Request::capture());
