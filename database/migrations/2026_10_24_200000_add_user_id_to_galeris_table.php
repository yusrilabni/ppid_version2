<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            if (!Schema::hasColumn('galeris', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('saq_answer_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            if (Schema::hasColumn('galeris', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
};
