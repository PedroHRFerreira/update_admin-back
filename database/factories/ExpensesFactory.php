<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expenses>
 */
class ExpensesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'month' => $this->faker->unique()->monthName(),
            'expenses_current' => $this->faker->randomFloat(2, 100, 1000),
            'expenses_previous' => $this->faker->randomFloat(2, 100, 1000),
            'expenses_next' => $this->faker->randomFloat(2, 100, 1000),
            'expenses_products' => $this->faker->randomFloat(2, 100, 1000),
            'highest_spending_product' => $this->faker->randomFloat(2, 100, 1000),
            'lowest_cost_product' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
