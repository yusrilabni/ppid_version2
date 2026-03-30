<?php

// AKTIFKAN ERROR REPORTING (HANYA UNTUK DIAGNOSTIK)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Cek Path Autoload (PASTIKAN PATH INI BENAR)
$autoloadPath = __DIR__.'/../../ppid_version2/vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die("Gagal: File autoload.php tidak ditemukan di path: " . $autoloadPath);
}
require $autoloadPath;

// 2. Cek Path Bootstrap (PASTIKAN PATH INI BENAR)
$appPath = __DIR__.'/../../ppid_version2/bootstrap/app.php';
if (!file_exists($appPath)) {
    die("Gagal: File bootstrap/app.php tidak ditemukan di path: " . $appPath);
}
$app = require_once $appPath;

// 3. Handle Request
$app->handleRequest(Request::capture());
