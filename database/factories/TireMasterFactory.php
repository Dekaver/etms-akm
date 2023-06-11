<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tire>
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
            'tire_size_id' => 1,
            'tire_compound_id' => 1,
            'tire_status_id' => 1,
            'tire_damage_id' => 1,
            'rtd' => 50,
            'lifetime_km' => 0,
            'lifetime_hm' => 0,
            'lifetime_retread_km' => 0,
            'lifetime_retread_hm' => 0,
            'lifetime_repair_km' => 0,
            'lifetime_repair_hm' => 0,
            'date' => fake()->date(),
            'is_repair' => 0,
            'is_retread' => 0,
        ];
    }
}