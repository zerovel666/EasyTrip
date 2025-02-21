<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CountryFactory extends Factory
{
    public function definition(): array
    {
        $countries = ['Казахстан', 'Россия', 'США', 'Франция', 'Германия', 'Италия', 'Испания', 'Китай', 'Япония', 'Турция'];
        $cities = ['Алматы', 'Москва', 'Нью-Йорк', 'Париж', 'Берлин', 'Рим', 'Мадрид', 'Пекин', 'Токио', 'Анкара'];

        $country = $this->faker->randomElement($countries);
        $city = $this->faker->randomElement($cities);

        return [
            'country_name' => $country,
            'trip_name' => 'Тур в ' . $city,
            'city_name' => $city,
            'price_per_day' => $this->faker->numberBetween(10000,30000),
            'count_place' => $this->faker->numberBetween(1, 50),
            'occupied' => $this->faker->numberBetween(1, 50),
            'image_path' => 'images/' . Str::random(10) . '.jpg',
            'currency' => 'KZT',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
