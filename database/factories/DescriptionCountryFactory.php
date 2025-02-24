<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Country;
use App\Models\DescriptionCountry;

class DescriptionCountryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country_id' => Country::whereNotIn('id', DescriptionCountry::pluck('country_id'))->inRandomOrder()->value('id'),
            'description' => $this->faker->paragraph(),
            'rating' => $this->faker->randomFloat(1, 1, 5), 
        ];
    }
}
