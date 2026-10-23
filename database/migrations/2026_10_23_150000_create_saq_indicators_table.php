<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bank pertanyaan SAQ e-monev (struktur hirarkis: tab > seksi > pertanyaan).
     * Tabel BARU — tidak menyentuh tabel yang sudah ada.
     */
    public function up(): void
    {
        Schema::create('saq_indicators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('tab', 100)->index();
            $table->string('kode', 20)->unique();
            $table->text('pertanyaan')->nullable();
            $table->string('section', 150)->nullable();
            $table->text('petunjuk')->nullable();
            $table->text('dokumen_upload')->nullable();
            $table->text('unit_terkait')->nullable();
            $table->boolean('is_category')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saq_indicators');
    }
};
