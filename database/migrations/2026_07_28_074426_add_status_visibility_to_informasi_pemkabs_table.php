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
        Schema::table('informasi_pemkabs', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('published')->after('file_path');
            $table->enum('visibility', ['public', 'private'])->default('public')->after('status');
            $table->timestamp('published_at')->nullable()->after('visibility');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_pemkabs', function (Blueprint $table) {
            $table->dropColumn(['status', 'visibility', 'published_at']);
        });
    }
};
