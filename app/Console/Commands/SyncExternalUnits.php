<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Cache;

class SyncExternalUnits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ppid:sync-units';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually fetch and cache all unit/desa data from the external API permanently';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mulai menarik data Unit, Desa, dan Kelurahan dari API Kepegawaian...');
        
        // Clear the old cache first
        Cache::forget('external_units_data_v2');
        
        // Call the helper which will now fetch fresh and save forever
        $data = GeneralHelper::syncExternalUnitsIfNeeded();
        
        $unitCount = count($data['units'] ?? []);
        $this->info("Berhasil menyimpan $unitCount OPD ke dalam database cache permanen.");
        
        $desaCount = 0;
        foreach ($data['villages_grouped'] ?? [] as $kecamatan => $desas) {
            $desaCount += count($desas);
        }
        $this->info("Berhasil menyimpan $desaCount Desa/Kelurahan ke dalam database cache permanen.");
        
        $this->info('Sinkronisasi selesai! Data tidak akan diupdate lagi sampai command ini dijalankan kembali.');
    }
}
