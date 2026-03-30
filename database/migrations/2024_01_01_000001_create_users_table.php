<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable()->unique()->comment('NIP untuk login via API');
            $table->string('name');
            $table->string('email')->nullable()->unique(); // Made nullable
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Role system
            $table->enum('role', ['superadmin', 'admin', 'user'])->default('user');
            
            // Data dari API
            $table->string('unit_id')->nullable();
            $table->string('jabatan_id')->nullable();
            $table->integer('admin_kabupaten')->default(0);
            $table->string('jabatan_atasan_id')->nullable();
            $table->boolean('admin_unit')->default(false);
            
            // Login type
            $table->enum('login_type', ['email', 'nip', 'google'])->default('email');
            
            // Google OAuth
            $table->string('google_id')->nullable();
            
            // Profile
            $table->string('profile_photo_path')->nullable();
            $table->text('bio')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('linkedin')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
            
            // Indexes
            $table->index('nip');
            $table->index('role');
            $table->index('login_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
