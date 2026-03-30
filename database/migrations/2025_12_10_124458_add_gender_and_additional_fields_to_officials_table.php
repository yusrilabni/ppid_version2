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
        Schema::table('officials', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable()->after('full_name'); // Gender
            $table->string('marital_status')->nullable()->after('nip'); // Marital status
            $table->string('occupation')->nullable()->after('spouse_name'); // Occupation
            $table->string('email')->nullable()->after('occupation'); // Email
            $table->text('home_address')->nullable()->after('email'); // Home address
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_kelamin',
                'marital_status',
                'occupation',
                'email',
                'home_address'
            ]);
        });
    }
};
