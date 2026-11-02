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
        if (Schema::hasTable('saq_answers') && !Schema::hasColumn('saq_answers', 'alasan')) {
            Schema::table('saq_answers', function (Blueprint $table) {
                $table->text('alasan')->nullable()->after('jawaban');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('saq_answers') && Schema::hasColumn('saq_answers', 'alasan')) {
            Schema::table('saq_answers', function (Blueprint $table) {
                $table->dropColumn('alasan');
            });
        }
    }
};
