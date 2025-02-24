<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\DescriptionCountry;
use App\Models\LikeCountry;
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
        LikeCountry::factory(50)->create();
        DescriptionCountry::factory(50)->create();

    }
}
