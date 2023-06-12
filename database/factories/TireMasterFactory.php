<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TireMaster>
 */
class TireMasterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => 1,
            'site_id' => 1,
            'tire_supplier_id' => 1,
            'serial_number' => strtoupper(fake()->lexify("???????")),
            'tire_size_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6]),
            'tire_compound_id' => $this->faker->randomElement([1, 2, 3, 4]),
            'tire_status_id' => $this->faker->randomElement([1, 2, 5]),
            'tire_damage_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'rtd' => $this->faker->randomNumber(2),
            'lifetime_km' => $this->faker->randomNumber(4),
            'lifetime_hm' => $this->faker->randomNumber(4),
            'lifetime_retread_km' => $this->faker->randomNumber(3),
            'lifetime_retread_hm' => $this->faker->randomNumber(3),
            'lifetime_repair_km' => $this->faker->randomNumber(3),
            'lifetime_repair_hm' => $this->faker->randomNumber(3),
            'date' => fake()->date(),
            'is_repair' => $this->faker->randomElement([0, 1]),
            'is_retread' => $this->faker->randomElement([0, 1]),
        ];
    }
}