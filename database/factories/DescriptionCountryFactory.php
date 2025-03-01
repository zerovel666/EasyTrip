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
            'title' => $this->faker->text(50),
            'description' => $this->faker->paragraph(6),
            'preview' => $this->faker->text(100)
        ];
    }
}
