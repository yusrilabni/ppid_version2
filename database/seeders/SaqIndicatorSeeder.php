<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\SaqIndicator;
use Illuminate\Support\Facades\DB;

class SaqIndicatorSeeder extends Seeder
{
    /**
     * Seed bank 203 pertanyaan SAQ e-monev + pemetaan ke OPD.
     * Pemetaan dari hasil analisis (2026-10-23): 150 ppid_utama, 38 semua_opd, 15 opd_tertentu.
     * Idempotent: aman dijalankan ulang (updateOrCreate per kode).
     */
    public function run(): void
    {
        $path = database_path('seeders/data/saq_questions.json');
        if (!file_exists($path)) {
            $this->command->error("File data tidak ditemukan: {$path}");
            return;
        }

        $items = json_decode(file_get_contents($path), true);
        if (!is_array($items)) {
            $this->command->error('Format JSON tidak valid.');
            return;
        }

        // Muat pemetaan hasil analisis
        $mapPath = database_path('seeders/data/saq_mapping.php');
        $mapping = file_exists($mapPath) ? require $mapPath : ['ppid_utama' => [], 'semua_opd' => [], 'opd_tertentu' => []];
        $ppidUtamaKodes = $mapping['ppid_utama'] ?? [];
        $semuaOpdKodes = $mapping['semua_opd'] ?? [];
        $opdTertentuMap = $mapping['opd_tertentu'] ?? []; // kode => [nama OPD...]

        // Fungsi tentukan scope dari kode pertanyaan
        $scopeOf = function ($kode) use ($ppidUtamaKodes, $semuaOpdKodes, $opdTertentuMap) {
            if (in_array($kode, $ppidUtamaKodes)) return 'ppid_utama';
            if (in_array($kode, $semuaOpdKodes)) return 'semua_opd';
            if (isset($opdTertentuMap[$kode])) return 'opd_tertentu';
            // Fallback: tab Sarana dan Prasarana -> ppid_utama, sisanya semua_opd
            return null;
        };

        // 1. Buat hirarkis: tab -> seksi -> pertanyaan
        $idMap = []; // kode => id
        $scopeMap = []; // kode => scope (untuk pertanyaan)
        // Urutkan: kategori dulu (level tab, section), lalu pertanyaan
        usort($items, fn($a, $b) => ($a['is_category'] === $b['is_category'])
            ? $a['order'] <=> $b['order']
            : ($b['is_category'] <=> $a['is_category']));

        // Proses dalam 3 pass agar parent selalu sudah ada
        foreach (['tab', 'section', 'question'] as $level) {
            foreach ($items as $item) {
                if ($item['level'] !== $level) continue;

                $parentId = null;
                if ($level === 'section') {
                    $parentKode = explode('.', $item['kode'])[0];
                    $parentId = $idMap[$parentKode] ?? null;
                } elseif ($level === 'question') {
                    $parts = explode('.', $item['kode']);
                    array_pop($parts);
                    $parentKode = implode('.', $parts);
                    $parentId = $idMap[$parentKode] ?? null;
                }

                // Tentukan scope: dari mapping, atau fallback ke tab (hanya untuk pertanyaan)
                $scope = null;
                if ($level === 'question') {
                    $scope = $scopeOf($item['kode']);
                    if ($scope === null) {
                        $scope = $item['tab'] === 'Sarana dan Prasarana' ? 'ppid_utama' : 'semua_opd';
                    }
                    $scopeMap[$item['kode']] = $scope;
                }

                $data = [
                    'parent_id' => $parentId,
                    'tab' => $item['tab'],
                    'pertanyaan' => $item['pertanyaan'],
                    'section' => $item['section'],
                    'petunjuk' => null,
                    'dokumen_upload' => $item['dokumen_upload'],
                    'unit_terkait' => $item['unit_terkait'],
                    'is_category' => $item['is_category'],
                    'order' => $item['order'],
                ];
                // Scope hanya untuk pertanyaan (kolom NOT NULL)
                if ($scope !== null) {
                    $data['scope'] = $scope;
                }

                $ind = SaqIndicator::updateOrCreate(
                    ['kode' => $item['kode']],
                    $data
                );
                $idMap[$item['kode']] = $ind->id;
            }
        }

        $this->command->info('SaqIndicator: ' . SaqIndicator::count() . ' records.');

        // 2. Ambil semua OPD (unit, tanpa kecamatan/desa/kelurahan)
        $opdIds = Organization::where('type', 'unit')
            ->where('slug', '!=', 'kabupaten-sinjai')
            ->where('name', 'not like', 'Kantor Kecamatan%')
            ->where('name', 'not like', 'Desa %')
            ->where('name', 'not like', 'Kelurahan %')
            ->pluck('id', 'name') // name => id untuk pencocokan
            ->toArray();

        $this->command->info('OPD ditemukan: ' . count($opdIds));

        // Entitas Kabupaten Sinjai (PPID Utama)
        $kabSinjai = Organization::updateOrCreate(
            ['slug' => 'kabupaten-sinjai'],
            ['name' => 'Kabupaten Sinjai', 'type' => 'unit', 'remote_id' => 0]
        );

        // 3. Petakan pertanyaan ke OPD berdasarkan scope
        $now = now();
        $rows = [];
        $stats = ['ppid_utama' => 0, 'semua_opd' => 0, 'opd_tertentu' => 0];

        // Ambil semua indicator pertanyaan dengan scope-nya
        $indicators = SaqIndicator::where('is_category', false)->get(['id', 'kode', 'scope']);

        // Bersihkan SEMUA mapping lama dulu (akan dibangun ulang)
        $deleted = DB::table('indicator_opd')->delete();
        if ($deleted) $this->command->info("Mapping lama dibersihkan: {$deleted} baris.");

        foreach ($indicators as $ind) {
            $scope = $ind->scope ?? $scopeMap[$ind->kode] ?? 'semua_opd';

            if ($scope === 'ppid_utama') {
                // Hanya Kabupaten Sinjai
                $rows[] = [
                    'indicator_id' => $ind->id,
                    'organization_id' => $kabSinjai->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                $stats['ppid_utama']++;
            } elseif ($scope === 'semua_opd') {
                // Semua OPD
                foreach ($opdIds as $oid) {
                    $rows[] = [
                        'indicator_id' => $ind->id,
                        'organization_id' => $oid,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                $stats['semua_opd']++;
            } elseif ($scope === 'opd_tertentu') {
                // OPD spesifik berdasarkan nama
                $targetNames = $opdTertentuMap[$ind->kode] ?? [];
                $matched = 0;
                foreach ($targetNames as $targetName) {
                    // Cari OPD dengan pencocokan nama fleksibel
                    $foundId = null;
                    foreach ($opdIds as $opdName => $oid) {
                        // Normalisasi: lowercase, hapus spasi ganda
                        $n1 = strtolower(preg_replace('/\s+/', ' ', $opdName));
                        $n2 = strtolower(preg_replace('/\s+/', ' ', $targetName));
                        if ($n1 === $n2 || str_contains($n1, $n2) || str_contains($n2, $n1)) {
                            $foundId = $oid;
                            break;
                        }
                    }
                    if ($foundId) {
                        $rows[] = [
                            'indicator_id' => $ind->id,
                            'organization_id' => $foundId,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                        $matched++;
                    } else {
                        $this->command->warn("OPD tidak ketemu untuk {$ind->kode}: {$targetName}");
                    }
                }
                $stats['opd_tertentu']++;
            }
        }

        // Insert dalam chunk
        foreach (array_chunk($rows, 1000) as $chunk) {
            DB::table('indicator_opd')->insert($chunk);
        }

        $this->command->info('indicator_opd: ' . DB::table('indicator_opd')->count() . ' mappings.');
        $this->command->info('Rincian: ppid_utama=' . $stats['ppid_utama'] . ' soal, semua_opd=' . $stats['semua_opd'] . ' soal, opd_tertentu=' . $stats['opd_tertentu'] . ' soal.');
    }
}
