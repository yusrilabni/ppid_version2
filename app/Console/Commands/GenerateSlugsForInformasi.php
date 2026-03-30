<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Informasi;

class GenerateSlugsForInformasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-slugs-informasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for existing Informasi records that do not have one.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to generate slugs for Informasi records...');

        $informasis = Informasi::whereNull('slug')->get();

        if ($informasis->isEmpty()) {
            $this->info('No records needed slug generation.');
            return;
        }

        $bar = $this->output->createProgressBar($informasis->count());
        $bar->start();

        foreach ($informasis as $informasi) {
            $informasi->save(); // The 'saving' event will handle the slug generation
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nSlug generation completed successfully for " . $informasis->count() . " records.");
    }
}