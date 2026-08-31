<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Override config
config(['database.connections.mysql.username' => 'root']);
config(['database.connections.mysql.password' => '']);
config(['database.connections.mysql.database' => 'ppid_laravel']);

use App\Models\Official;
use App\Models\Position;
use App\Helpers\GeneralHelper;

$position = Position::where('slug', 'kepala-opd')->first();
$officials = Official::where('position_id', $position->id)
    ->where('status', 'active')
    ->with('organization')
    ->get();

$officialMap = [];
foreach ($officials as $off) {
    if ($off->organization && $off->organization->remote_id) {
        $officialMap[$off->organization->remote_id] = $off;
    }
}

$cached = GeneralHelper::syncExternalUnitsIfNeeded();

$opds = [];
$kecamatans = [];
$desas = [];

$processUnit = function($unit, $isVillage = false) use ($officialMap, &$opds, &$kecamatans, &$desas) {
    $remoteId = $isVillage ? $unit['desa_id'] : $unit['unit_id'];
    $unitName = $isVillage ? ($unit['desa_tipe'] . ' ' . $unit['desa_nama']) : $unit['unit_nama'];
    
    $officialName = 'Belum Ada Data / Kosong';
    $isUpdated = false;
    
    if (isset($officialMap[$remoteId])) {
        $off = $officialMap[$remoteId];
        $officialName = $off->full_name;
        if (stripos($officialName, 'Pejabat') === 0 || stripos($officialName, 'Pejabat ') !== false) {
            $isUpdated = false;
        } else {
            $isUpdated = true;
        }
    }
    
    $nameLower = strtolower($unitName);
    if (str_contains($nameLower, 'pemerintah daerah')) return;

    $text = "- {$unitName}: *" . trim($officialName) . "*";
    if (!$isUpdated) {
        $text .= " _(Belum Update)_";
    }
    
    if ($isVillage) {
        $desas[] = $text;
    } elseif (str_contains($nameLower, 'kecamatan ')) {
        $kecamatans[] = $text;
    } else {
        $opds[] = $text;
    }
};

if (!empty($cached['units'])) {
    foreach ($cached['units'] as $unit) {
        $processUnit($unit, false);
    }
}

if (!empty($cached['villages_grouped'])) {
    foreach ($cached['villages_grouped'] as $kecamatan => $items) {
        foreach ($items as $village) {
            $processUnit($village, true);
        }
    }
}

sort($opds);
sort($kecamatans);
sort($desas);

$msg = "PENGUMUMAN UPDATE DATA PIMPINAN DAERAH\n\n";
$msg .= "Yth. Bapak/Ibu Admin OPD/Kecamatan/Desa,\n";
$msg .= "Berikut adalah daftar nama pimpinan masing-masing unit organisasi yang terdata di sistem saat ini.\n";
$msg .= "*Apabila ada perubahan data pimpinan, silakan segera di-update. Jika tertulis (Belum Update), mohon segera mengisi data yang valid.*\n\n";

$msg .= "*[ DINAS / BADAN / KANTOR ]*\n";
$msg .= implode("\n", $opds) . "\n\n";

$msg .= "*[ KECAMATAN ]*\n";
$msg .= implode("\n", $kecamatans) . "\n\n";

$msg .= "*[ DESA & KELURAHAN ]*\n";
$msg .= implode("\n", $desas) . "\n\n";

$msg .= "Terima Kasih.\n";

file_put_contents('C:/Users/ASUS/.gemini/antigravity-cli/brain/b295ce56-6659-4b98-8586-5f50d2fbe15b/Daftar_Pimpinan_Update.md', $msg);
echo "Generated C:/Users/ASUS/.gemini/antigravity-cli/brain/b295ce56-6659-4b98-8586-5f50d2fbe15b/Daftar_Pimpinan_Update.md\n";
