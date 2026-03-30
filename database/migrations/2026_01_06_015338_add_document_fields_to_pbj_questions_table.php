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
        Schema::table('pbj_questions', function (Blueprint $table) {
            $table->string('document_url')->nullable()->after('order');
            $table->string('document_file_path')->nullable()->after('document_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pbj_questions', function (Blueprint $table) {
            $table->dropColumn(['document_url', 'document_file_path']);
        });
    }
};
