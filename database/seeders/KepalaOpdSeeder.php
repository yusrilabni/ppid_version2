<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\OrganizationPosition;
use Illuminate\Support\Facades\DB;

class KepalaOpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $organizations = Organization::all();

            foreach ($organizations as $organization) {
                OrganizationPosition::firstOrCreate(
                    [
                        'organization_id' => $organization->id,
                        'name' => 'Kepala ' . $organization->name,
                    ],
                    [
                        'title' => 'Kepala',
                        'parent_id' => null,
                        'order_number' => 1,
                    ]
                );
            }
        });
    }
}
