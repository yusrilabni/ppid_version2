<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SubStandarLayanan;

class GenerateSlugsForSubStandarLayanan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-slugs-sub-standar-layanan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for existing SubStandarLayanan records that do not have one.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to generate slugs for SubStandarLayanan records...');

        $items = SubStandarLayanan::whereNull('slug')->get();

        if ($items->isEmpty()) {
            $this->info('No records needed slug generation.');
            return;
        }

        $bar = $this->output->createProgressBar($items->count());
        $bar->start();

        foreach ($items as $item) {
            $item->save(); // The 'saving' event will handle the slug generation
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nSlug generation completed successfully for " . $items->count() . " records.");
    }
}