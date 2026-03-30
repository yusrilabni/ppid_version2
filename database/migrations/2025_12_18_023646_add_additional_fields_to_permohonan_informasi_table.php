<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permohonan_informasi', function (Blueprint $table) {
            $table->string('pekerjaan')->nullable()->after('alamat_pemohon');
            $table->text('cara_memperoleh_informasi')->nullable()->after('tujuan_penggunaan_informasi');
            $table->text('cara_mendapatkan_salinan')->nullable()->after('cara_memperoleh_informasi');
            $table->string('tempat_mendapatkan_salinan')->nullable()->after('cara_mendapatkan_salinan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan_informasi', function (Blueprint $table) {
            $table->dropColumn(['pekerjaan', 'cara_memperoleh_informasi', 'cara_mendapatkan_salinan', 'tempat_mendapatkan_salinan']);
        });
    }
};
