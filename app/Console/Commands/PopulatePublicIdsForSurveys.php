<?php

namespace App\Console\Commands;

use App\Models\Survey;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PopulatePublicIdsForSurveys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-public-ids-for-surveys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the public_id for existing surveys that have a null value.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $surveysToUpdate = Survey::whereNull('public_id')->get();
        $count = 0;

        foreach ($surveysToUpdate as $survey) {
            do {
                $public_id = '';
                // Ensure at least one letter and one number
                $public_id .= Str::upper(Str::random(1)); // At least one letter
                $public_id .= rand(0, 9); // At least one number
                // Fill the rest
                $remaining_length = 3;
                $public_id .= Str::upper(Str::random($remaining_length));
                // Shuffle the result
                $public_id = str_shuffle($public_id);
            } while (Survey::where('public_id', $public_id)->exists());
            
            $survey->public_id = $public_id;
            $survey->save();
            $count++;
        }

        $this->info("Successfully populated public_id for {$count} surveys.");
    }
}
