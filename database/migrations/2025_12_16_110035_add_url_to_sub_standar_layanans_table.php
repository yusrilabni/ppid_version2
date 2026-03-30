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
            $table->string('url')->nullable()->after('file');
            $table->string('file_type')->default('upload')->after('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_standar_layanans', function (Blueprint $table) {
            $table->dropColumn(['url', 'file_type']);
        });
    }
};
