<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\DescriptionCountry;
use App\Models\ImageCountry;
use App\Models\LikeCountry;
use App\Models\Tags;
use App\Models\TripImages;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Country::factory(50)->create();
        // User::factory(50)->create();
        LikeCountry::factory(rand(100,500))->create();
        Country::all()->each(function ($country) {
            Tags::factory()->count(rand(3, 4))->create([
                'country_id' => $country->id
            ]);
        });

        $countries = Country::select('id')->get();

        foreach ($countries as $country) {
            ImageCountry::factory()->create([
                'country_id' => $country->id, 
            ]);
            DescriptionCountry::factory()->create([
                'country_id' => $country->id
            ]);
        }
        // LikeCountry::factory(1)->create();
        // DescriptionCountry::factory(1)->create();
        // Country::all()->each(function ($country) {
        //     Tags::factory()->count(rand(3, 4))->create([
        //         'country_id' => $country->id
        //     ]);
        //     ImageCountry::factory()->create([
        //         'country_id' => $country->id,
        //     ]);
        // });
    }
}
