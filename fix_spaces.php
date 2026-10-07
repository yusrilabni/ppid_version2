<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

echo "Memulai perbaikan nama file (spasi -> underscore)...\n";

// Fix Galeri
$galeris = DB::table('galeris')->where('image', 'LIKE', '% %')->get();
foreach($galeris as $galeri) {
    $oldPath = $galeri->image;
    if (empty($oldPath)) continue;

    $newPath = str_replace(' ', '_', $oldPath);
    echo "Galeri ID {$galeri->id}: '$oldPath' -> '$newPath'\n";

    if (Storage::disk('public')->exists($oldPath)) {
        Storage::disk('public')->move($oldPath, $newPath);
        echo "  [OK] File fisik berhasil direname.\n";
    } else {
        echo "  [WARN] File fisik tidak ditemukan di disk: $oldPath\n";
        // Check if the underscored version already exists (maybe renamed manually)
        if (Storage::disk('public')->exists($newPath)) {
            echo "  [INFO] File dengan underscore sudah ada. Melanjutkan update DB.\n";
        }
    }

    DB::table('galeris')->where('id', $galeri->id)->update(['image' => $newPath]);
}

// Fix Informasi
$informasis = DB::table('informasis')->where('file', 'LIKE', '% %')->get();
foreach($informasis as $info) {
    $oldPath = $info->file;
    if (empty($oldPath)) continue;

    $newPath = str_replace(' ', '_', $oldPath);
    echo "Informasi ID {$info->id}: '$oldPath' -> '$newPath'\n";

    if (Storage::disk('public')->exists($oldPath)) {
        Storage::disk('public')->move($oldPath, $newPath);
        echo "  [OK] File fisik berhasil direname.\n";
    } else {
        echo "  [WARN] File fisik tidak ditemukan di disk: $oldPath\n";
        if (Storage::disk('public')->exists($newPath)) {
            echo "  [INFO] File dengan underscore sudah ada. Melanjutkan update DB.\n";
        }
    }

    DB::table('informasis')->where('id', $info->id)->update(['file' => $newPath]);
}

echo "Selesai!\n";
