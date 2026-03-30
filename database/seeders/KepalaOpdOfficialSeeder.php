<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Official;
use App\Models\Position;
use App\Models\OrganizationPosition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KepalaOpdOfficialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $kepalaOpdPosition = Position::where('slug', 'kepala-opd')->first();

            if (!$kepalaOpdPosition) {
                $this->command->error('Generic "Kepala OPD" position not found. Please run the PositionsSeeder first.');
                return;
            }

            $kepalaOpdOrganizationPositions = OrganizationPosition::whereNull('parent_id')
                ->with('organization')
                ->get();

            $this->command->info('Found ' . $kepalaOpdOrganizationPositions->count() . ' "Kepala OPD" positions to seed.');

            foreach ($kepalaOpdOrganizationPositions as $orgPos) {
                if ($orgPos->organization) {
                    // Define the attributes to check for existence
                    $attributes = [
                        'position_id'     => $kepalaOpdPosition->id,
                        'organization_id' => $orgPos->organization_id,
                    ];

                    // Check if an official for this position/organization already exists
                    if (!Official::where($attributes)->exists()) {
                        $fullName = 'Pejabat ' . $orgPos->organization->name;
                        
                        // Generate a unique slug
                        $baseSlug = Str::slug($fullName);
                        $slug = $baseSlug;
                        $counter = 1;
                        while (Official::where('slug', $slug)->exists()) {
                            $slug = $baseSlug . '-' . $counter;
                            $counter++;
                        }

                        // Data for the new official
                        $data = [
                            'full_name'       => $fullName,
                            'slug'            => $slug,
                            'status'          => 'draft',
                        ];

                        Official::create(array_merge($attributes, $data));

                        $this->command->info("Created official: {$fullName}");
                    } else {
                        $this->command->line("Skipping official for " . $orgPos->organization->name . " (already exists).");
                    }
                }
            }
        });
    }
}
