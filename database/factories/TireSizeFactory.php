<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TireSize>
 */
class TireSizeFactory extends Factory
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
            'tire_pattern_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'size' => $this->faker->randomElement(["27.00R49", "12.00R24", "11.00R20"]),
            'otd' => 80,
            'recomended_pressure' => 120,
            'target_lifetime_hm' => 10000,
            'target_lifetime_km' => 10000,
            'price' => $this->faker->numberBetween(800000, 2000000),
        ];
    }
}
