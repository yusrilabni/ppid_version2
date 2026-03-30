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
        Schema::table('pbj_question_documents', function (Blueprint $table) {
            $table->string('url')->nullable()->change();
            $table->string('type')->default('link')->after('url');
            $table->string('file_path')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pbj_question_documents', function (Blueprint $table) {
            $table->string('url')->nullable(false)->change();
            $table->dropColumn('type');
            $table->dropColumn('file_path');
        });
    }
};
