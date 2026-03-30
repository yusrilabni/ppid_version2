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
        Schema::table('profil_ppids', function (Blueprint $blueprint) {
            $blueprint->string('instagram')->nullable()->after('maps_url');
            $blueprint->string('facebook')->nullable()->after('instagram');
            $blueprint->string('twitter')->nullable()->after('facebook');
            $blueprint->string('tiktok')->nullable()->after('twitter');
            $blueprint->string('youtube')->nullable()->after('tiktok');
            $blueprint->string('website')->nullable()->after('youtube');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_ppids', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['instagram', 'facebook', 'twitter', 'tiktok', 'youtube', 'website']);
        });
    }
};
