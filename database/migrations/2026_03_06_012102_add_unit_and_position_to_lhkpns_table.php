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
            $table->unsignedBigInteger('official_id')->nullable()->change();
            $table->unsignedBigInteger('organization_id')->nullable()->after('official_id');
            $table->unsignedBigInteger('position_id')->nullable()->after('organization_id');
            $table->string('full_name')->nullable()->after('position_id'); // Backup name in case official is deleted or not set
            
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lhkpns', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropForeign(['position_id']);
            
            $table->dropColumn(['organization_id', 'position_id', 'full_name']);
            $table->unsignedBigInteger('official_id')->nullable(false)->change();
        });
    }
};
