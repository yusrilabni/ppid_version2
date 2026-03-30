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
            $table->dropColumn(['main_ppid_photo', 'main_ppid_name', 'main_ppid_position', 'ppid_members']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_ppids', function (Blueprint $table) {
            $table->string('main_ppid_photo')->nullable();
            $table->string('main_ppid_name')->nullable();
            $table->string('main_ppid_position')->nullable();
            $table->json('ppid_members')->nullable();
        });
    }};
