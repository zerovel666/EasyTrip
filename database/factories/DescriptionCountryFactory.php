<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Country;

class DescriptionCountryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country_id' => Country::inRandomOrder()->value('id'), 
            'description' => $this->faker->paragraph(),
            'rating' => $this->faker->randomFloat(1, 1, 5), 
        ];
    }
}
