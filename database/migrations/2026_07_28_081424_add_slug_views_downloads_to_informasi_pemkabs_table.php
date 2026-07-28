<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('informasi_pemkabs', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('judul');
            $table->integer('views_count')->default(0)->after('status');
            $table->integer('downloads_count')->default(0)->after('views_count');
        });

        // Update existing records with dummy slug
        $records = DB::table('informasi_pemkabs')->get();
        foreach ($records as $record) {
            DB::table('informasi_pemkabs')->where('id', $record->id)->update([
                'slug' => Str::slug($record->judul) . '-' . $record->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_pemkabs', function (Blueprint $table) {
            $table->dropColumn(['slug', 'views_count', 'downloads_count']);
        });
    }
};
