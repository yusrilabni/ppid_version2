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
            $table->unsignedBigInteger('saq_answer_id')->nullable()->after('id');
        });
        Schema::table('informasi_pemkabs', function (Blueprint $table) {
            $table->unsignedBigInteger('saq_answer_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasis', function (Blueprint $table) {
            $table->dropColumn('saq_answer_id');
        });
        Schema::table('informasi_pemkabs', function (Blueprint $table) {
            $table->dropColumn('saq_answer_id');
        });
    }
};
