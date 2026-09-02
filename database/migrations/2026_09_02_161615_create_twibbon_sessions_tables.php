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
        Schema::create('twibbon_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('twibbon_id')->nullable()->constrained('twibbons')->nullOnDelete();
            $table->string('result_image_path');
            $table->timestamps();
        });

        Schema::create('twibbon_session_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('twibbon_session_id')->constrained('twibbon_sessions')->cascadeOnDelete();
            $table->string('raw_image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twibbon_session_photos');
        Schema::dropIfExists('twibbon_sessions');
    }
};
