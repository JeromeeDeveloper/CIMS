<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deceased>
 */
class DeceasedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    

    public function definition(): array
    {
        return [
            'service_id' => 1,
            'address_id' => 1,
            'lastaction_by' => 'DR. PATRICIO P. PARAMI JR.',
            'causeofdeath' => $this->faker->randomElement(['A', 'H', 'N', 'U', 'O']),
            'lastname' => strtoupper($this->faker->lastname),
            'firstname' => strtoupper($this->faker->firstname),
            'middlename' => strtoupper($this->faker->lastname),
            'approvalStatus' => random_int(0, 1),
            'suffix' => $this->faker->randomElement(['N', 'I', 'III', 'IV', 'V']),
            'civilstatus' => $this->faker->randomElement(['S', 'M', 'D', 'W']),
            'sex' => $this->faker->randomElement(['M', 'F']),
            'dateof_death' => $this->faker->dateTimeBetween('-24 years', 'now'),
            'dateof_burial' => $this->faker->dateTimeBetween('-24 years', 'now'),
            'burial_time' => now()->format('H:i:s'),
            'dateofbirth' => $this->faker->dateTimeBetween('-90 years', 'now'),
        ];
    }
}
