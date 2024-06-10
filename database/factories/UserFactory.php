<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => strtoupper($this->faker->name),
            'role' => 3,
            'address_id' => 1,
            'contactnumber' => '639878976332',
            'email' => $this->faker->email,
            'email_verified_at' => now(),
            'password' => Hash::make($this->faker->email), // password
            'remember_token' => Str::random(10),
            'relationshipthdeceased' =>  random_int(1,6),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
