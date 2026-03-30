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
            $table->foreignId('sub_standar_layanan_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasis', function (Blueprint $table) {
            $table->dropForeign(['sub_standar_layanan_id']);
            $table->dropColumn('sub_standar_layanan_id');
        });
    }
};