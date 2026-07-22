<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use PhpOffice\PhpSpreadsheet\IOFactory;

try {
    $spreadsheet = IOFactory::load("Laporan_Survei_6_20260720_033115.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray(null, true, true, true);
    
    if (empty($data)) die("Empty sheet");
    
    $headers = array_shift($data);
    
    $filteredData = [];
    foreach ($data as $row) {
        if (!empty($row['A']) || !empty($row['B'])) {
            $filteredData[] = $row;
        }
    }
    
    $N = count($filteredData);
    echo "Jumlah Responden (N) = $N\n\n";
    
    foreach ($headers as $col => $qText) {
        if (empty($qText) || in_array($qText, ['No', 'Tanggal', 'IP Address', 'Nama Responden', 'Privasi'])) continue;
        
        $counts = [];
        foreach ($filteredData as $row) {
            $val = $row[$col];
            if (!isset($counts[$val])) $counts[$val] = 0;
            $counts[$val]++;
        }
        echo "Q: $qText\n";
        foreach ($counts as $val => $c) {
            $pct = round(($c / $N) * 100, 2);
            echo "   '$val' => $c ($pct%)\n";
        }
        echo "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
