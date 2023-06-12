<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "company_id" => 1,
            "unit_model_id" => 1,
            "unit_status_id" => 1,
            "site_id" => 1,
            "unit_number" => strtoupper(fake()->unique()->bothify("DT###?")),
            "head" => 1,
            "km" => 1,
            "hm" => 1,
        ];
    }
}