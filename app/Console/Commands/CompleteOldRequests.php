<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PermohonanInformasi;
use Carbon\Carbon;

class CompleteOldRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permohonan:complete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically mark old, followed-up requests as \'selesai\' after 3 days and default the rating to 5 stars if not provided.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to check for old, answered requests to complete...');

        $threeDaysAgo = Carbon::now()->subDays(3);

        // Get requests that are 'diproses' and have responses.
        $requests = PermohonanInformasi::where('status_permohonan', 'diproses')->has('responses')->get();

        $completedCount = 0;

        foreach ($requests as $request) {
            // Get the last response. The responses are ordered by created_at by default.
            $lastResponse = $request->responses->last();

            // If the last response was a 'Tindaklanjut' and is older than 3 days, proceed.
            if ($lastResponse && $lastResponse->response_type === 'Tindaklanjut' && $lastResponse->created_at->lt($threeDaysAgo)) {
                // If the user has not provided a rating, default it to 5 stars.
                if (is_null($request->rating)) {
                    $request->rating = 5;
                    $this->line("Request #{$request->id} has been auto-rated with 5 stars.");
                }
                
                $request->status_permohonan = 'selesai';
                $request->save();
                $completedCount++;
                $this->line("Request #{$request->id} has been marked as 'selesai'.");
            }
        }

        $this->info("Completed a total of {$completedCount} requests.");
        return 0;
    }
}
