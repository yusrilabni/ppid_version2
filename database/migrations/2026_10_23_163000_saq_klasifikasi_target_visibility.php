<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saq_indicators', function (Blueprint $table) {
            // Klasifikasi informasi otomatis per pertanyaan (UU KIP)
            $table->string('klasifikasi_otomatis', 50)->nullable()->after('scope');
            // Target upload: ppid -> informasis, pemkab -> informasi_pemkabs
            $table->string('target_upload', 10)->default('ppid')->after('klasifikasi_otomatis');
        });

        Schema::table('saq_answers', function (Blueprint $table) {
            $table->string('visibility', 10)->default('public')->after('jawaban');
        });
    }

    public function down(): void
    {
        Schema::table('saq_indicators', function (Blueprint $table) {
            $table->dropColumn(['klasifikasi_otomatis', 'target_upload']);
        });
        Schema::table('saq_answers', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
};
