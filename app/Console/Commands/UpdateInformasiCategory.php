<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Informasi;
use Carbon\Carbon;

class UpdateInformasiCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ppid:update-informasi-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pindahkan Informasi Berkala yang lebih dari 6 bulan ke Informasi Setiap Saat';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memeriksa Informasi Berkala yang lebih dari 6 bulan...');

        $sixMonthsAgo = Carbon::now()->subMonths(6);

        $informasiToUpdate = Informasi::where('category', 'Informasi Berkala')
            ->where('tanggal_upload', '<=', $sixMonthsAgo)
            ->get();

        if ($informasiToUpdate->isEmpty()) {
            $this->info('Tidak ada Informasi Berkala yang perlu dipindahkan.');
            return;
        }

        $this->info("Ditemukan {$informasiToUpdate->count()} informasi untuk dipindahkan.");

        foreach ($informasiToUpdate as $informasi) {
            $informasi->category = 'Informasi Setiap Saat';
            $informasi->save();
        }

        $this->info('Selesai. Semua informasi yang relevan telah dipindahkan ke Informasi Setiap Saat.');
    }
}
