<?php

namespace Database\Factories;

use App\Models\CareerHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CareerHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CareerHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'organization_name' => $this->faker->company,
            'start_year' => $this->faker->year,
            'end_year' => $this->faker->year,
            'description' => $this->faker->paragraph,
        ];
    }
}
