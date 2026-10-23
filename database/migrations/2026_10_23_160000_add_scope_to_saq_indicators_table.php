<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saq_indicators', function (Blueprint $table) {
            // semua_opd = diisi semua OPD; ppid_utama = hanya PPID Utama (Diskominfo)
            $table->string('scope', 20)->default('semua_opd')->after('kode');
        });
    }

    public function down(): void
    {
        Schema::table('saq_indicators', function (Blueprint $table) {
            $table->dropColumn('scope');
        });
    }
};
