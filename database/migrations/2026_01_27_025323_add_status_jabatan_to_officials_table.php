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
        Schema::table('officials', function (Blueprint $table) {
            $table->enum('status_jabatan', [
                'Definitif',
                'Penjabat (Pj)',
                'Pelaksana Tugas (Plt)',
                'Pelaksana Harian (Plh)',
                'Pejabat Sementara (Pjs)',
            ])->default('Definitif')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            $table->dropColumn('status_jabatan');
        });
    }
};
