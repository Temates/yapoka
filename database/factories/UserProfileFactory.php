<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=> fake()->unique()->numberBetween(1, User::count()),
            'full_name' => fake()->name(),
            'handphone_number' => fake()->unique()->phoneNumber() ,
            'address' => fake()->unique()->address(),           
            
        ];
    }
}
