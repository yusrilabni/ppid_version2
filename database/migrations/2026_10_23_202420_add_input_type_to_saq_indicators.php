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
        Schema::table('saq_indicators', function (Blueprint $table) {
            $table->string('input_type', 20)->default('dokumen')->after('target_upload')
                ->comment('dokumen: judul+link, foto: upload/link langsung, situs: url saja, link: link saja');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saq_indicators', function (Blueprint $table) {
            $table->dropColumn('input_type');
        });
    }
};
