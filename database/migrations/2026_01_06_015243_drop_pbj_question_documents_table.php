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
        Schema::dropIfExists('pbj_question_documents');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('pbj_question_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pbj_question_id');
            $table->string('title');
            $table->string('url')->nullable();
            $table->string('type')->default('link');
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->foreign('pbj_question_id')->references('id')->on('pbj_questions')->onDelete('cascade');
        });
    }
};
