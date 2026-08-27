<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Informasi;
use Illuminate\Support\Facades\DB;

class SyncViewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ppid:sync-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync views_count between Informasi and InformasiPemkab records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $records = Informasi::whereNotNull('informasi_pemkab_id')->get();
        $count = 0;
        
        foreach($records as $info) {
            $pemkab = DB::table('informasi_pemkabs')->where('id', $info->informasi_pemkab_id)->first();
            if ($pemkab) {
                $max = max($info->views_count, $pemkab->views_count);
                DB::table('informasis')->where('id', $info->id)->update(['views_count' => $max]);
                DB::table('informasi_pemkabs')->where('id', $pemkab->id)->update(['views_count' => $max]);
                $count++;
            }
        }
        
        try {
            \Illuminate\Support\Facades\Cache::tags(['informasi'])->flush();
            $this->info("Cache cleared.");
        } catch (\Exception $e) {}

        $this->info("Synced views for {$count} records successfully!");
    }
}
