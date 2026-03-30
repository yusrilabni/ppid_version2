<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Informasi;
use App\Models\Official;

class LinkOfficialInformationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'informasi:link-officials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Links existing Informasi records (official profiles) to their respective Official records.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to link existing official information records...');

        $informasis = Informasi::where('category', 'Informasi Berkala')
                               ->whereNull('official_id')
                               ->get();

        if ($informasis->isEmpty()) {
            $this->info('No unlinked official information records found.');
            return 0;
        }

        $this->withProgressBar($informasis, function ($informasi) {
            $officialId = null;

            // Try to get official_id from content JSON
            $contentData = json_decode($informasi->content, true);
            if (is_array($contentData) && isset($contentData['id'])) {
                $officialId = $contentData['id'];
            }

            if ($officialId) {
                // Check if the official actually exists
                $official = Official::find($officialId);
                if ($official) {
                    $informasi->official_id = $officialId;
                    $informasi->save();
                    $this->comment("Linked Informasi ID: {$informasi->id} to Official ID: {$officialId}");
                } else {
                    $this->warn("Official with ID: {$officialId} not found for Informasi ID: {$informasi->id}. Skipping.");
                }
            } else {
                $this->warn("Could not extract official ID from content for Informasi ID: {$informasi->id}. Skipping.");
            }
        });

        $this->info("\nLinking process completed.");

        return 0;
    }
}