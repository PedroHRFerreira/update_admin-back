<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sales;

class SalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_get(): void
    {
        Sales::create([
            'month' => 'Janeiro',
            'value' => 1000.00,
            'quantity' => 5,
            'name' => 'Produto A',
            'description' => 'Descrição do produto A'
        ]);

        $response = $this->get('/api/sales');
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_sales_post(): void
    {
        $payload = [
            'month' => 'Fevereiro',
            'value' => 1500.75,
            'quantity' => 3,
            'name' => 'Produto B',
            'description' => 'Descrição do produto B'
        ];

        $response = $this->post('/api/sales', $payload);
        $response->dump();
        $response->assertStatus(200)->assertJson([
            'status' => 'success',
            'message' => 'Vendas carregados com sucesso'
        ]);

        $this->assertDatabaseHas('sales', $payload);
    }

    public function test_sales_delete(): void
{
    $sale = Sales::create([
        'month' => 'Março',
        'value' => 900.00,
        'quantity' => 2,
        'name' => 'Produto C',
        'description' => 'Descrição do produto C'
    ]);

    $response = $this->delete("/api/sales/{$sale->id}");

    $response->dump(); // ajuda se quiser ver a resposta

    $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'Venda removido com sucesso'
             ]);

    // Confirma que foi excluído
    $this->assertDatabaseMissing('sales', ['id' => $sale->id]);
}


}
