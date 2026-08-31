<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$position = \App\Models\Position::where('slug', 'kepala-opd')->first();
$assignedOrgIds = \App\Models\Official::where('position_id', $position->id)->pluck('organization_id')->toArray();
$assignedRemoteIds = \App\Models\Organization::whereIn('id', $assignedOrgIds)->pluck('remote_id')->toArray();

$cached = \App\Helpers\GeneralHelper::syncExternalUnitsIfNeeded();
$desas = [];
$kecamatans = [];
$opds = [];

if (!empty($cached['units'])) {
    foreach ($cached['units'] as $unit) {
        if (!in_array($unit['unit_id'], $assignedRemoteIds)) {
            $nameLower = strtolower($unit['unit_nama']);
            $unitData = [
                'id' => 'ext_' . $unit['unit_id'],
                'name' => $unit['unit_nama']
            ];
            
            if (str_contains($nameLower, 'desa ') || str_contains($nameLower, 'kelurahan ')) {
                $desas[] = $unitData;
            } elseif (str_contains($nameLower, 'kecamatan ')) {
                $kecamatans[] = $unitData;
            } else {
                $opds[] = $unitData;
            }
        }
    }
}

if (!empty($cached['villages'])) {
    foreach ($cached['villages'] as $village) {
        if (!in_array($village['desa_id'], $assignedRemoteIds)) {
            $desas[] = [
                'id' => 'ext_v_' . $village['desa_id'],
                'name' => 'Desa ' . $village['desa_nama']
            ];
        }
    }
}

echo 'OPD Belum Isi: ' . count($opds) . PHP_EOL;
echo 'Kecamatan Belum Isi: ' . count($kecamatans) . PHP_EOL;
echo 'Desa/Kelurahan Belum Isi: ' . count($desas) . PHP_EOL;
