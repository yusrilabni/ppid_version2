<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jawaban SAQ per OPD per indikator.
     * Tabel BARU — tidak menyentuh tabel yang sudah ada.
     * Tanpa FK constraint (demi keamanan production); relasi di-handle di model.
     */
    public function up(): void
    {
        Schema::create('saq_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->index();
            $table->unsignedBigInteger('indicator_id')->index();
            $table->string('judul', 255);
            $table->text('link')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();

            $table->unique(['organization_id', 'indicator_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saq_answers');
    }
};
