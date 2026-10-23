<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pivot: pertanyaan SAQ <-> OPD yang berpotensi memiliki dokumen terkait.
     * Tabel BARU — tidak menyentuh tabel yang sudah ada.
     */
    public function up(): void
    {
        Schema::create('indicator_opd', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id')->index();
            $table->unsignedBigInteger('organization_id')->index();
            $table->timestamps();

            $table->unique(['indicator_id', 'organization_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicator_opd');
    }
};
