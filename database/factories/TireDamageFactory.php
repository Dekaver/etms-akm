<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TireDamage>
 */
class TireDamageFactory extends Factory
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
            'damage' => $this->faker->unique()->firstNameMale(),
            "cause" => $this->faker->randomElement(["Operational", "Maintenance", "Normal"]),
            "rating" => "A",
        ];
    }
}