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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->boolean('is_single')->default(false); // For positions like Bupati, Wakil Bupati, Sekda
            $table->timestamps();
        });

        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('type', ['opd', 'kecamatan', 'unit'])->default('opd');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->foreign('parent_id')->references('id')->on('organizations')->onDelete('set null');
        });

        Schema::create('officials', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('organization_id')->nullable(); // Required for Kepala OPD
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('religion')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('address')->nullable();
            $table->string('nip')->nullable();
            $table->text('biography')->nullable();
            $table->string('photo')->nullable();
            $table->date('start_term')->nullable();
            $table->date('end_term')->nullable();
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('set null');
        });

        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('official_id');
            $table->string('name');
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->timestamps();

            $table->foreign('official_id')->references('id')->on('officials')->onDelete('cascade');
        });

        Schema::create('career_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('official_id');
            $table->string('title');
            $table->string('organization_name')->nullable();
            $table->year('start_year')->nullable();
            $table->year('end_year')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->foreign('official_id')->references('id')->on('officials')->onDelete('cascade');
        });

        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('official_id');
            $table->string('degree');
            $table->string('institution');
            $table->year('start_year')->nullable();
            $table->year('end_year')->nullable();
            $table->timestamps();
            
            $table->foreign('official_id')->references('id')->on('officials')->onDelete('cascade');
        });

        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('official_id');
            $table->string('title');
            $table->string('issuer');
            $table->year('year')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->foreign('official_id')->references('id')->on('officials')->onDelete('cascade');
        });

        Schema::create('training_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('official_id');
            $table->string('name');
            $table->string('organizer')->nullable();
            $table->year('year')->nullable();
            $table->timestamps();

            $table->foreign('official_id')->references('id')->on('officials')->onDelete('cascade');
        });

        Schema::create('organizational_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('official_id');
            $table->string('organization_name');
            $table->string('position');
            $table->year('start_year')->nullable();
            $table->year('end_year')->nullable();
            $table->timestamps();

            $table->foreign('official_id')->references('id')->on('officials')->onDelete('cascade');
        });

        Schema::create('organization_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->onDelete('cascade');
            $table->string('title');
            $table->string('name')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('organization_positions')->onDelete('cascade');
            $table->integer('order_number')->default(0);
            $table->boolean('show_title')->default(true);
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('struktur_organisasis', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_organisasis');
        Schema::dropIfExists('organization_positions');
        Schema::dropIfExists('organizational_histories');
        Schema::dropIfExists('training_histories');
        Schema::dropIfExists('awards');
        Schema::dropIfExists('educations');
        Schema::dropIfExists('career_histories');
        Schema::dropIfExists('children');
        Schema::dropIfExists('officials');
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('positions');
    }
};