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
        Schema::create('profil_ppids', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('status')->default(true);
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->string('structure_image')->nullable(); // Path to structure image
            $table->string('main_ppid_photo')->nullable(); // Path to Main PPID photo
            $table->string('main_ppid_name')->nullable();
            $table->string('main_ppid_position')->nullable();
            $table->json('ppid_members')->nullable(); // JSON array for optional members
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('service_hours')->nullable();
            $table->string('maps_url')->nullable(); // Google Maps URL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_ppids');
    }
};
