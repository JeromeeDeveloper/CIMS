<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'region_no' => 10,
            'region' =>  'REGION X (NORTHERN MINDANAO) ',
            'province_no' => 1043,
            'province' => 'MISAMIS ORIENTAL',
            'city_no' => 104316,
            'city' => 'LUGAIT',
            'barangay_no' => 104316007,
            'barangay' => 'POBLACION',
        ];
    }
}
