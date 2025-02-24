<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition()
    {
        $role = ['student','admin'];
        return [
            'full_name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'iin' => $this->faker->numberBetween(111111111111,999999999999),
            'role' => array_rand($role)
        ];
    }
}
