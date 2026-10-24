<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hybrid dokumen SAQ: jejak balik ke dokumen PPID asli yang di-sync.
     * Hanya tambah kolom (aman untuk production), tanpa foreign key,
     * mengikuti pola tabel SAQ.
     */
    public function up(): void
    {
        Schema::table('saq_answer_links', function (Blueprint $table) {
            $table->unsignedBigInteger('informasi_id')->nullable()->after('link');
            $table->string('sumber_informasi')->nullable()->after('informasi_id');
            $table->index('informasi_id');
        });
    }

    public function down(): void
    {
        Schema::table('saq_answer_links', function (Blueprint $table) {
            $table->dropIndex(['informasi_id']);
            $table->dropColumn(['informasi_id', 'sumber_informasi']);
        });
    }
};
