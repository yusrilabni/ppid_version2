<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('link_access_logs', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->index();
            $table->string('type'); // widget atau rss
            $table->integer('access_count')->default(1);
            $table->timestamp('last_access')->useCurrent();
            
            $table->unique(['domain', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_access_logs');
    }
};
