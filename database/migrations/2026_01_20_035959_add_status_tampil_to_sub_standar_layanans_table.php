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
        Schema::table('sub_standar_layanans', function (Blueprint $table) {
            $table->string('status_tampil')->default('draft')->after('jenis_dokumen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_standar_layanans', function (Blueprint $table) {
            $table->dropColumn('status_tampil');
        });
    }
};