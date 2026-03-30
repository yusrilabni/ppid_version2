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
        if (!Schema::hasColumn('sliders', 'show_title')) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->boolean('show_title')->default(true)->after('active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sliders', 'show_title')) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->dropColumn('show_title');
            });
        }
    }
};
