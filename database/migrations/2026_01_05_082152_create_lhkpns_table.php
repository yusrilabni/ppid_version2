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
        Schema::create('lhkpns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('official_id');
            $table->integer('report_year');
            $table->string('report_type');
            $table->date('report_date');
            $table->bigInteger('total_wealth');
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('official_id')->references('id')->on('officials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lhkpns');
    }
};