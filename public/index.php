<?php

// Paksa tampilkan error jika ada masalah PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Tentukan lokasi folder source code (ppid_version2) secara absolut
// Ini lebih aman daripada menggunakan ../../
$basePath = realpath(__DIR__ . '/../../ppid_version2');

if (!$basePath) {
    die("Error: Folder 'ppid_version2' tidak ditemukan. Pastikan folder tersebut ada di root (sejajar dengan public_html).");
}

// 1. Register Autoloader
$autoload = $basePath . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    die("Error: File '$autoload' tidak ditemukan. Sudahkah Anda mengupload folder 'vendor'?");
}
require $autoload;

// 2. Bootstrap Laravel
$appFile = $basePath . '/bootstrap/app.php';
if (!file_exists($appFile)) {
    die("Error: File '$appFile' tidak ditemukan.");
}
$app = require_once $appFile;

// 3. Handle Request
$app->handleRequest(Request::capture());
