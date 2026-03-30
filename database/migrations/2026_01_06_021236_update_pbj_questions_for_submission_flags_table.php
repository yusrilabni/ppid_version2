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
            $table->dropColumn(['document_url', 'document_file_path']);
            $table->boolean('requires_link_submission')->default(false)->after('order');
            $table->boolean('requires_file_submission')->default(false)->after('requires_link_submission');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pbj_questions', function (Blueprint $table) {
            $table->string('document_url')->nullable();
            $table->string('document_file_path')->nullable();
            $table->dropColumn(['requires_link_submission', 'requires_file_submission']);
        });
    }
};
