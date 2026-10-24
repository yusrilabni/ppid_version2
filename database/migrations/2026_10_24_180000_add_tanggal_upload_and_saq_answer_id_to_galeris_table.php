<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Hanya tambah kolom (aman untuk production): tanggal_upload terpisah
     * dari created_at, dan saq_answer_id sebagai jejak balik jawaban SAQ
     * (tanpa foreign key, mengikuti pola tabel SAQ).
     */
    public function up(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            $table->date('tanggal_upload')->nullable()->after('category');
            $table->unsignedBigInteger('saq_answer_id')->nullable()->index()->after('tanggal_upload');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            $table->dropColumn(['tanggal_upload', 'saq_answer_id']);
        });
    }
};
