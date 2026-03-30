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
        Schema::table('informasis', function (Blueprint $table) {
            $table->string('jenis_dokumen')->after('category')->nullable();
            $table->year('tahun')->after('jenis_dokumen')->nullable();
            $table->string('file')->after('tahun')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasis', function (Blueprint $table) {
            $table->dropColumn(['jenis_dokumen', 'tahun', 'file']);
        });
    }
};