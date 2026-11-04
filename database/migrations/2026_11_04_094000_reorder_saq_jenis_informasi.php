<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\SaqIndicator;
use App\Models\Organization;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Dapatkan section-section utama pada tab 'Jenis Informasi'
        $sec31 = SaqIndicator::where('tab', 'Jenis Informasi')
            ->where(function($q) {
                $q->where('kode', '3.1')->orWhere('section', 'A. Informasi Berkala');
            })->where('level', 'section')->first();

        $sec34 = SaqIndicator::where('tab', 'Jenis Informasi')
            ->where(function($q) {
                $q->where('kode', '3.4')->orWhere('section', 'B. Informasi Setiap Saat');
            })->where('level', 'section')->first();

        $sec35 = SaqIndicator::where('tab', 'Jenis Informasi')
            ->where(function($q) {
                $q->where('kode', '3.5')->orWhere('section', 'C. Informasi Serta Merta');
            })->where('level', 'section')->first();

        $sec36 = SaqIndicator::where('tab', 'Jenis Informasi')
            ->where(function($q) {
                $q->where('kode', '3.6')->orWhere('section', 'like', '%Pengadaan Barang%');
            })->where('level', 'section')->first();

        if ($sec31) {
            $sec31->order = 1;
            $sec31->save();
        }
        if ($sec34) {
            $sec34->order = 2;
            $sec34->save();
        }
        if ($sec35) {
            $sec35->order = 3;
            $sec35->save();
        }

        $sec31Id = $sec31 ? $sec31->id : null;

        // 2. Satukan grup Pengadaan Barang dan Jasa ke bawah Section 3.1 (A. Informasi Berkala)
        if ($sec31Id) {
            // RUP (EM-JI-110 / id 342)
            DB::table('saq_indicators')->where('id', 342)->update([
                'parent_id' => $sec31Id,
                'order' => 14,
            ]);

            // Paket 2025 (id 375 / 3.6.b)
            DB::table('saq_indicators')->where('id', 375)->update([
                'parent_id' => $sec31Id,
                'order' => 15,
            ]);

            // Paket 2026 (id 433 / GRP-d452e884)
            DB::table('saq_indicators')->where('id', 433)->update([
                'parent_id' => $sec31Id,
                'order' => 16,
            ]);

            // Tahap Pemilihan (id 381 / d.)
            DB::table('saq_indicators')->where('id', 381)->update([
                'parent_id' => $sec31Id,
                'order' => 17,
            ]);

            // Tahap Pelaksanaan (id 382 / e.)
            DB::table('saq_indicators')->where('id', 382)->update([
                'parent_id' => $sec31Id,
                'order' => 18,
            ]);
        }

        // Hapus/nonaktifkan section redundan 3.6 jika ada
        if ($sec36) {
            DB::table('saq_indicators')->where('id', $sec36->id)->delete();
        }

        // 3. Rapikan urutan (order) item-item di Section A. Informasi Berkala (1 - 11)
        // 1.a Profil: Mengumumkan Informasi tentang : (id 380)
        DB::table('saq_indicators')->where('id', 380)->update(['order' => 1]);
        // 1.b Profil: Pejabat Struktural (id 379)
        DB::table('saq_indicators')->where('id', 379)->update(['order' => 2]);
        // 1.c Profil: LHKPN 2025 (id 430)
        DB::table('saq_indicators')->where('id', 430)->update(['order' => 3]);
        // 1.d Profil: LHKSN (id 300)
        DB::table('saq_indicators')->where('id', 300)->update(['order' => 4]);

        // 2. Tugas pokok Pemkab 2025-2026 (id 388)
        DB::table('saq_indicators')->where('id', 388)->update(['order' => 5]);

        // 3. Laporan Keuangan 2025 (id 389)
        DB::table('saq_indicators')->where('id', 389)->update(['order' => 6]);

        // 4. Ringkasan Laporan Akses Informasi 2025 (id 390)
        DB::table('saq_indicators')->where('id', 390)->update(['order' => 7]);

        // 5. Peraturan / Kebijakan 2025 & 2026 (id 391)
        DB::table('saq_indicators')->where('id', 391)->update(['order' => 8]);

        // 6. Prosedur Memperoleh Informasi Publik (id 392)
        DB::table('saq_indicators')->where('id', 392)->update(['order' => 9]);

        // 7. Pengaduan Penyalahgunaan Wewenang (id 435 / EM-JI-155)
        DB::table('saq_indicators')->where('id', 435)->update(['order' => 10]);

        // 8. Ketenagakerjaan (id 436 / EM-JI-156)
        DB::table('saq_indicators')->where('id', 436)->update(['order' => 11]);

        // 9. Peringatan Dini & Evakuasi Darurat (id 201 / 3.1.42)
        DB::table('saq_indicators')->where('id', 201)->update(['order' => 12]);

        // 10. Keuangan Daerah (id 432 / GRP-a8ecd3aa)
        DB::table('saq_indicators')->where('id', 432)->update(['order' => 13]);

        // 4. Rapikan urutan item-item di Section B. Informasi Setiap Saat (1 - 15)
        // 1. DIP 2025 (id 30)
        DB::table('saq_indicators')->where('id', 30)->update(['order' => 1]);
        // 2. DIP 2026 (id 46)
        DB::table('saq_indicators')->where('id', 46)->update(['order' => 2]);
        // 3. DPA & RKA 2026 (id 60)
        DB::table('saq_indicators')->where('id', 60)->update(['order' => 3]);
        // 4. Peraturan / Kebijakan rentang 2025-2026 (id 383)
        DB::table('saq_indicators')->where('id', 383)->update(['order' => 4]);
        // 5. Organisasi, adm, kepeg, keu rentang 2025-2026 (id 386)
        DB::table('saq_indicators')->where('id', 386)->update(['order' => 5]);
        // 6. Surat perjanjian pihak ketiga (id 384)
        DB::table('saq_indicators')->where('id', 384)->update(['order' => 6]);
        // 7. Surat menyurat pimpinan/pejabat (id 385)
        DB::table('saq_indicators')->where('id', 385)->update(['order' => 7]);
        // 8 & 9. Perizinan & Perbendaharaan/BMD (id 434)
        DB::table('saq_indicators')->where('id', 434)->update(['order' => 8]);
        // 10. Renstra yang masih berlaku (id 176)
        DB::table('saq_indicators')->where('id', 176)->update(['order' => 10]);
        // 11. Laporan Layanan Informasi Publik 2025 (id 178)
        DB::table('saq_indicators')->where('id', 178)->update(['order' => 11]);
        // 12. Pelanggaran pengawasan internal 2025 (id 180)
        DB::table('saq_indicators')->where('id', 180)->update(['order' => 12]);
        // 13. Pelanggaran dilaporkan masyarakat 2025 (id 182)
        DB::table('saq_indicators')->where('id', 182)->update(['order' => 13]);
        // 14. Daftar & hasil penelitian 2025-2026 (id 184)
        DB::table('saq_indicators')->where('id', 184)->update(['order' => 14]);
        // 15. Informasi & kebijakan pertemuan publik 2025-2026 (id 186)
        DB::table('saq_indicators')->where('id', 186)->update(['order' => 15]);

        // 5. Pemetaan OPD Dinas Pekerjaan Umum dan Penataan Ruang (PUPR, id 15)
        // Hubungkan semua pertanyaan Pengadaan Barang dan Jasa ke PUPR
        $puprOrg = Organization::where('id', 15)
            ->orWhere('slug', 'dinas-pekerjaan-umum-dan-penataan-ruang')
            ->first();

        if ($puprOrg) {
            $pbjIndicatorIds = [
                // RUP
                342,
                // Paket 2025 (parent + items)
                375, 343, 344,
                // Paket 2026 (parent + items)
                433, 448, 449,
                // Tahap Pemilihan (parent + 13 items)
                381, 242, 243, 244, 245, 246, 247, 248, 249, 250, 251, 252, 253, 254,
                // Tahap Pelaksanaan (parent + 11 items)
                382, 255, 256, 257, 258, 259, 260, 261, 262, 263, 264, 265,
            ];

            foreach ($pbjIndicatorIds as $indId) {
                DB::table('indicator_opd')->updateOrInsert(
                    [
                        'indicator_id' => $indId,
                        'organization_id' => $puprOrg->id,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu reverse destructive
    }
};
