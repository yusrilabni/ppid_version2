<?php
/**
 * SCRIPT PERBAIKAN OTOMATIS STORAGE (SINJAI PPID)
 * Jalankan ini di: https://ppidkab.sinjaikab.go.id/v2/fix_storage.php
 */

header('Content-Type: text/plain');
echo "MEMULAI PERBAIKAN STORAGE...\n\n";

// 1. Cek Folder Public Saat Ini
$publicPath = __DIR__;
echo "Lokasi Public: $publicPath\n";

$conflictingStorage = $publicPath . '/storage';
if (file_exists($conflictingStorage)) {
    if (is_link($conflictingStorage)) {
        echo "Menghapus Symlink lama yang rusak...\n";
        unlink($conflictingStorage);
    } elseif (is_dir($conflictingStorage)) {
        $newName = $conflictingStorage . '_backup_' . time();
        echo "Mengubah nama folder storage fisik yang mengganggu menjadi: " . basename($newName) . "\n";
        rename($conflictingStorage, $newName);
    }
} else {
    echo "Folder 'storage' pengganggu sudah tidak ada. Bagus.\n";
}

// 2. Cek Folder Target di ppid_version2
$targetStorage = realpath($publicPath . '/../../ppid_version2/storage/app/public');
if (!$targetStorage) {
    // Coba path alternatif cPanel
    $targetStorage = '/home/ppidkab/ppid_version2/storage/app/public';
}

echo "Target Storage: $targetStorage\n";

if (file_exists($targetStorage)) {
    echo "Folder target DITEMUKAN.\n";
    
    // Cek satu file contoh
    $sampleFile = $targetStorage . '/sliders/0MTVEsxr59JP2IHBdlFWbOknR4xwxhmP9PMRYrzv.png';
    if (file_exists($sampleFile)) {
        echo "File contoh sliders DITEMUKAN. Izin file: " . substr(sprintf('%o', fileperms($sampleFile)), -4) . "\n";
    } else {
        echo "File contoh sliders TIDAK ditemukan di: $sampleFile\n";
        echo "Isi folder target:\n";
        print_r(array_slice(scandir($targetStorage), 0, 10));
    }
} else {
    echo "ERROR: Folder target ppid_version2/storage/app/public TIDAK ditemukan!\n";
}

// 3. Instruksi Akhir
echo "\nSELESAI.\n";
echo "Silakan coba buka kembali website Anda.\n";
echo "Jika masih error 500, pastikan Anda sudah menyalin index.php terbaru dari ppid_version2/public/index.php\n";
