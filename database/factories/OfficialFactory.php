<?php

namespace Database\Factories;

use App\Models\Official;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OfficialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Official::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fullName = $this->faker->name();
        return [
            'full_name' => $fullName,
            'slug' => Str::slug($fullName),
            'position_id' => Position::factory(),
            'status' => 'active',
            'biography' => $this->faker->paragraph,
        ];
    }
}
