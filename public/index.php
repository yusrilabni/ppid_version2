<?php
echo "<h1>SISTEM PPID V2: PHP BERHASIL JALAN</h1>";
echo "Lokasi Folder: " . __DIR__ . "<br>";
$path = realpath(__DIR__ . '/../../ppid_version2');
echo "Path ke Source: " . ($path ? $path : "TIDAK DITEMUKAN");

/* 
// Nanti kita aktifkan lagi jika tes ini berhasil
require __DIR__.'/../../ppid_version2/vendor/autoload.php';
$app = require_once __DIR__.'/../../ppid_version2/bootstrap/app.php';
$app->handleRequest(Illuminate\Http\Request::capture());
*/
