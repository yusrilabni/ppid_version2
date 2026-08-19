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
            $table->index('unit_id', 'idx_unit_id');
            $table->index('status', 'idx_status');
            $table->index('category', 'idx_category');
            $table->index('tahun', 'idx_tahun');
            $table->index('slug', 'idx_slug');
        });

        Schema::table('officials', function (Blueprint $table) {
            $table->index('status', 'idx_official_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasis', function (Blueprint $table) {
            $table->dropIndex('idx_unit_id');
            $table->dropIndex('idx_status');
            $table->dropIndex('idx_category');
            $table->dropIndex('idx_tahun');
            $table->dropIndex('idx_slug');
        });

        Schema::table('officials', function (Blueprint $table) {
            $table->dropIndex('idx_official_status');
        });
    }
};
