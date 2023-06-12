<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TireCompound>
 */
class TireCompoundFactory extends Factory
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
            'compound'=> $this->faker->randomElement(['STANDARD', 'CUT RESISTANCE', 'HEAT RESISTANCE']),
        ];
    }
}
