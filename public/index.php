<?php

/**
 * DIRECT STORAGE FALLBACK (SINJAI PPID)
 * Memaksa server mengambil file dari folder ppid_version2 jika di public_html tidak ada.
 */
$uri = $_SERVER['REQUEST_URI'] ?? '';

// Cari apakah URL mengandung kata 'storage/'
if (strpos($uri, '/storage/') !== false) {
    // Ambil bagian setelah 'storage/'
    $parts = explode('/storage/', $uri);
    $filePath = end($parts);
    $filePath = explode('?', $filePath)[0]; // Buang query string
    
    // Tentukan lokasi absolut folder storage aplikasi
    // 1. Berdasarkan folder saat ini (public_html/v2/) ke ppid_version2
    $basePath1 = __DIR__ . '/../../ppid_version2/storage/app/public/';
    // 2. Berdasarkan path absolut cPanel Anda
    $basePath2 = '/home/ppidkab/ppid_version2/storage/app/public/';

    $locations = [
        $basePath1 . $filePath,
        $basePath2 . $filePath
    ];

    foreach ($locations as $fullPath) {
        if (file_exists($fullPath) && is_file($fullPath)) {
            // Deteksi MIME Type sederhana
            $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            $mimes = [
                'png'  => 'image/png',
                'jpg'  => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'gif'  => 'image/gif',
                'webp' => 'image/webp',
                'pdf'  => 'application/pdf',
                'svg'  => 'image/svg+xml',
            ];
            
            $mime = $mimes[$ext] ?? 'application/octet-stream';
            
            // Kirim file ke browser
            header("Content-Type: $mime");
            header("Content-Length: " . filesize($fullPath));
            header("Access-Control-Allow-Origin: *"); // Izinkan akses dari mana saja
            readfile($fullPath);
            exit;
        }
    }
}

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Path ke aplikasi
$appPath = __DIR__.'/../../ppid_version2';

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
