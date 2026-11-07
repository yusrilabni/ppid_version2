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
        Schema::create('keberatan_informasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('permohonan_informasi_id')->nullable()->constrained('permohonan_informasi')->onDelete('set null');
            $table->string('nomor_pendaftaran_pemohon')->index();
            $table->string('nama_pemohon');
            $table->text('alamat_pemohon');
            $table->string('pekerjaan')->nullable();
            $table->string('nomor_telepon_pemohon');
            $table->string('email_pemohon');
            
            // Identitas Kuasa Pemohon (Opsional)
            $table->string('nama_kuasa')->nullable();
            $table->text('alamat_kuasa')->nullable();
            $table->string('nomor_telepon_kuasa')->nullable();
            $table->string('surat_kuasa_path')->nullable();
            
            // Alasan & Kasus Posisi Keberatan
            $table->string('alasan_keberatan');
            $table->text('kasus_posisi');
            
            // Privasi, Status, Tanggapan, Kode Registrasi
            $table->enum('privacy_status', ['Publik', 'Anonim', 'Rahasia'])->default('Publik');
            $table->string('status_keberatan')->default('pending');
            $table->timestamp('tanggal_tanggapan')->nullable();
            $table->string('unique_code', 10)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keberatan_informasi');
    }
};
