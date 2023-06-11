<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TirePattern>
 */
class TirePatternFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_id' => 1,
            'pattern' => 'BLF-155',
            'type_pattern' => $this->faker->randomElement(['LUG', 'MIX', 'RIB']),
            'tire_manufacture_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
        ];
    }
}