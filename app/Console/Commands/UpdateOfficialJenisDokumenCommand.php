<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Informasi;

class UpdateOfficialJenisDokumenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'informasi:update-official-jenis-dokumen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the jenis_dokumen for all Informasi records linked to an official.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update jenis_dokumen for official information records...');

        $updatedCount = Informasi::whereNotNull('official_id')
                                ->update(['jenis_dokumen' => 'Informasi Organisasi & Kepegawaian']);

        if ($updatedCount > 0) {
            $this->info("Successfully updated {$updatedCount} records.");
        } else {
            $this->info('No records needed to be updated.');
        }

        return 0;
    }
}