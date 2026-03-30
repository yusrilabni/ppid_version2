<?php

namespace Database\Factories;

use App\Models\OrganizationalHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationalHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrganizationalHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'organization_name' => $this->faker->company,
            'position' => $this->faker->jobTitle,
            'start_year' => $this->faker->year,
            'end_year' => $this->faker->year,
        ];
    }
}
