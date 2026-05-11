<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sub_standar_layanans', function (Blueprint $table) {
            $table->date('tahun_dokumen')->change();
        });

        // Now update existing year values to full dates (YYYY-01-01)
        // This query will run AFTER the column type has been changed to DATE
        if (DB::getDriverName() === 'mysql') {
            DB::statement("UPDATE sub_standar_layanans SET tahun_dokumen = CONCAT(tahun_dokumen, '-01-01') WHERE LENGTH(tahun_dokumen) = 4");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_standar_layanans', function (Blueprint $table) {
            // Revert to year, potentially truncating existing date values
            $table->year('tahun_dokumen')->change();
        });
    }
};
