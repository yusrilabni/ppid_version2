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
        Schema::table('lhkpns', function (Blueprint $table) {
            $table->bigInteger('total_wealth')->nullable()->change();
            $table->string('report_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lhkpns', function (Blueprint $table) {
            $table->bigInteger('total_wealth')->nullable(false)->change();
            $table->string('report_type')->nullable(false)->change();
        });
    }
};