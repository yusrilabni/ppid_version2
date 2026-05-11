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
        Schema::table('informasis', function (Blueprint $table) {
            $table->enum('status_keterbukaan', ['Terbuka', 'Dikecualikan'])->default('Terbuka')->after('category');
            $table->integer('tahun_berakhir_pengecualian')->nullable()->after('status_keterbukaan');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE informasis MODIFY COLUMN category ENUM('Informasi Berkala', 'Informasi Serta Merta', 'Informasi Setiap Saat', 'Informasi Dikecualikan') NULL DEFAULT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasis', function (Blueprint $table) {
            $table->dropColumn('status_keterbukaan');
            $table->dropColumn('tahun_berakhir_pengecualian');
        });
        
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE informasis MODIFY COLUMN category VARCHAR(255) NULL DEFAULT NULL");
        }
    }
};
