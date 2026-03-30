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
        Schema::create('permohonan_informasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemohon');
            $table->text('alamat_pemohon');
            $table->string('nomor_telepon_pemohon');
            $table->string('email_pemohon');
            $table->text('detail_informasi');
            $table->text('tujuan_penggunaan_informasi');
            $table->string('status_permohonan')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_informasi');
    }
};
