<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\SaqIndicator;
use Illuminate\Support\Facades\DB;

class SaqIndicatorSeeder extends Seeder
{
    /**
     * Seed bank 203 pertanyaan SAQ e-monev + pemetaan ke seluruh OPD.
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

        // 1. Buat hirarkis: tab -> seksi -> pertanyaan
        $idMap = []; // kode => id
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
                    // kode section = "1.A" -> parent kode tab = "1"
                    $parentKode = explode('.', $item['kode'])[0];
                    $parentId = $idMap[$parentKode] ?? null;
                } elseif ($level === 'question') {
                    // kode question = "1.A.1" -> parent kode section = "1.A"
                    $parts = explode('.', $item['kode']);
                    array_pop($parts);
                    $parentKode = implode('.', $parts);
                    $parentId = $idMap[$parentKode] ?? null;
                }

                $ind = SaqIndicator::updateOrCreate(
                    ['kode' => $item['kode']],
                    [
                        'parent_id' => $parentId,
                        'tab' => $item['tab'],
                        'pertanyaan' => $item['pertanyaan'],
                        'section' => $item['section'],
                        'petunjuk' => null,
                        'dokumen_upload' => $item['dokumen_upload'],
                        'unit_terkait' => $item['unit_terkait'],
                        'is_category' => $item['is_category'],
                        'order' => $item['order'],
                        // Tab Sarana dan Prasarana hanya diisi PPID Utama (Diskominfo)
                        'scope' => $item['tab'] === 'Sarana dan Prasarana' ? 'ppid_utama' : 'semua_opd',
                    ]
                );
                $idMap[$item['kode']] = $ind->id;
            }
        }

        $this->command->info('SaqIndicator: ' . SaqIndicator::count() . ' records.');

        // 2. Ambil semua OPD (unit, tanpa kecamatan/desa/kelurahan)
        //    Kecualikan entitas Kabupaten Sinjai (khusus PPID Utama, hanya dapat tab Sarana-Prasarana)
        $opdIds = Organization::where('type', 'unit')
            ->where('slug', '!=', 'kabupaten-sinjai')
            ->where('name', 'not like', 'Kantor Kecamatan%')
            ->where('name', 'not like', 'Desa %')
            ->where('name', 'not like', 'Kelurahan %')
            ->pluck('id')
            ->toArray();

        $this->command->info('OPD ditemukan: ' . count($opdIds));

        // 3. Petakan pertanyaan ke OPD:
        //    - scope ppid_utama (Sarana dan Prasarana) -> hanya entitas "Kabupaten Sinjai"
        //    - scope semua_opd -> semua OPD (termasuk Diskominfo sebagai OPD biasa)
        $kabSinjai = Organization::updateOrCreate(
            ['slug' => 'kabupaten-sinjai'],
            ['name' => 'Kabupaten Sinjai', 'type' => 'unit', 'remote_id' => 0]
        );

        $ppidUtamaQids = SaqIndicator::where('is_category', false)
            ->where('scope', 'ppid_utama')->pluck('id')->toArray();
        $semuaOpdQids = SaqIndicator::where('is_category', false)
            ->where('scope', 'semua_opd')->pluck('id')->toArray();

        $now = now();
        $rows = [];
        foreach ($semuaOpdQids as $qid) {
            foreach ($opdIds as $oid) {
                $rows[] = [
                    'indicator_id' => $qid,
                    'organization_id' => $oid,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        // Bersihkan mapping lama ppid_utama yang bukan ke Kabupaten Sinjai (mis. ke Diskominfo)
        $deleted = DB::table('indicator_opd')
            ->whereIn('indicator_id', $ppidUtamaQids)
            ->where('organization_id', '!=', $kabSinjai->id)
            ->delete();
        if ($deleted) $this->command->info("Mapping lama dibersihkan: {$deleted} baris.");

        foreach ($ppidUtamaQids as $qid) {
            $rows[] = [
                'indicator_id' => $qid,
                'organization_id' => $kabSinjai->id,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // insertOrIgnore agar idempotent
        foreach (array_chunk($rows, 1000) as $chunk) {
            DB::table('indicator_opd')->insertOrIgnore($chunk);
        }

        $this->command->info('indicator_opd: ' . DB::table('indicator_opd')->count() . ' mappings.');
    }
}
