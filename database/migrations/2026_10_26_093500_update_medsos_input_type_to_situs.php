<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Soal akun media sosial diisi dengan link akun langsung, bukan dokumen:
     * EM-SP-003 Facebook, EM-SP-004 Instagram, EM-SP-005 Twitter/X,
     * EM-SP-006 Tiktok, EM-SP-007 Youtube.
     */
    public function up(): void
    {
        DB::table('saq_indicators')
            ->whereIn('kode', ['EM-SP-003', 'EM-SP-004', 'EM-SP-005', 'EM-SP-006', 'EM-SP-007'])
            ->update(['input_type' => 'situs']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('saq_indicators')
            ->whereIn('kode', ['EM-SP-003', 'EM-SP-004', 'EM-SP-005', 'EM-SP-006', 'EM-SP-007'])
            ->update(['input_type' => 'dokumen']);
    }
};
