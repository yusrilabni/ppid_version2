<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Kolom jawaban Ya/Tidak di saq_answers
        Schema::table('saq_answers', function (Blueprint $table) {
            $table->enum('jawaban', ['ya', 'tidak'])->nullable()->after('indicator_id');
        });

        // 2. Tabel link ganda per jawaban
        Schema::create('saq_answer_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saq_answer_id')->constrained('saq_answers')->cascadeOnDelete();
            $table->string('judul');
            $table->string('link', 2000);
            $table->text('deskripsi')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // 3. Migrasi data lama: yang sudah terisi -> jawaban 'ya', pindahkan judul/link
        $now = now();
        $answers = DB::table('saq_answers')
            ->whereNotNull('judul')
            ->orWhereNotNull('link')
            ->get();
        foreach ($answers as $a) {
            DB::table('saq_answers')->where('id', $a->id)->update(['jawaban' => 'ya']);
            if ($a->link || $a->judul) {
                DB::table('saq_answer_links')->insert([
                    'saq_answer_id' => $a->id,
                    'judul' => $a->judul ?? '(tanpa judul)',
                    'link' => $a->link ?? '',
                    'order' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('saq_answer_links');
        Schema::table('saq_answers', function (Blueprint $table) {
            $table->dropColumn('jawaban');
        });
    }
};
