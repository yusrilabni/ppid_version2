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
        Schema::create('security_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->unique();
            $table->text('reason')->nullable();
            $table->json('request_data')->nullable(); // Optional, store last request
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_blocks');
    }
};
