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
        Schema::table('pbj_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('informasi_id')->nullable()->after('pbj_question_id');
            $table->foreign('informasi_id')->references('id')->on('informasis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pbj_answers', function (Blueprint $table) {
            $table->dropForeign(['informasi_id']);
            $table->dropColumn('informasi_id');
        });
    }
};
