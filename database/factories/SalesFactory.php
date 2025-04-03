<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales>
 */
class SalesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'month' => fake()->unique()->monthName(),
            'quantity' => fake()->randomNumber(),
            'value' => fake()->randomFloat(2, 0, 100),
            'description' => fake()->text(),
        ];
    }
}
