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
    // Pada cPanel, dari /public_html/v2/, folder aplikasi ada di /ppid_version2/
    $priorities = [
        __DIR__ . '/../../ppid_version2/storage/app/public/' . $filePath,
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

/**
 * PENYESUAIAN PATH CPANEL
 * Karena index.php ada di /public_html/v2/
 * Dan aplikasi ada di /ppid_version2/
 */
$appPath = __DIR__.'/../../ppid_version2';

// 1. Cek Maintenance Mode
if (file_exists($maintenance = $appPath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 2. Register Autoloader
if (file_exists($autoload = $appPath.'/vendor/autoload.php')) {
    require $autoload;
} else {
    die("Autoloader tidak ditemukan di: " . $autoload);
}

// 3. Bootstrap Laravel
if (file_exists($bootstrap = $appPath.'/bootstrap/app.php')) {
    $app = require_once $bootstrap;
} else {
    die("Bootstrap tidak ditemukan di: " . $bootstrap);
}

// 4. Handle Request
$app->handleRequest(Request::capture());
