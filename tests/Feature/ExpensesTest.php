<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Expenses;

class ExpensesTest extends TestCase
{
    use RefreshDatabase;

    public function test_expanses_get(): void
    {
        Expenses::create([
            'expenses_current' => 1000.00,
            'expenses_previous' => 1000.00,
            'expenses_next' => 1000.00,
            'expenses_products' => 1000.00,
            'highest_spending_product' => 1000.00,
            'lowest_cost_product' => 1000.00,
        ]);

        $response = $this->get('/api/expenses');
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_expanses_get_filters(): void
    {
        Expenses::create([
            'expenses_current' => 1000.00,
            'expenses_previous' => 1000.00,
            'expenses_next' => 1000.00,
            'expenses_products' => 1000.00,
            'highest_spending_product' => 1000.00,
            'lowest_cost_product' => 1000.00,
        ]);

        $response = $this->get('/api/expenses?filter[expenses_current]=1000.00');
        $response->dump();
        $response->assertStatus(200);
    }
}
