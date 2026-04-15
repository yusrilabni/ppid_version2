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
        // Biarkan kosong karena kolom sudah ada di database cPanel
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasis', function (Blueprint $table) {
            if (Schema::hasColumn('informasis', 'village_id')) {
                $table->dropColumn('village_id');
            }
        });
    }
};
