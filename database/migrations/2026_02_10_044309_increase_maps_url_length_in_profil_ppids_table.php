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
        Schema::table('profil_ppids', function (Blueprint $table) {
            $table->text('maps_url')->change();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_ppids', function (Blueprint $table) {
            $table->string('maps_url')->nullable()->change();
        });
    }};
