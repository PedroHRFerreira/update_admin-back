<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Products;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_get(): void
    {
        Products::create([
           "name" => "Rebeca Harber",
           "description" => "Totam praesentium laudantium asperiores nisi eum excepturi excepturi. Nulla maiores fugit et ut natus. Sed ut ad sunt soluta.",
           "price" => 29.33,
           "image" => "https://via.placeholder.com/640x480.png/007711?text=aut",
           "quantity" => 9382808,
        ]);

        $response = $this->get('/api/products');
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_products_post(): void
    {
        $payload = [
            'name' => 'Produto Teste',
            'description' => 'Descrição do produto teste',
            'price' => 99.99,
            'quantity' => 10,
            'image' => 'https://via.placeholder.com/640x480.png/007711?text=aut'
        ];

        $response = $this->post('/api/products', $payload);
        $response->dump();
        $response->assertStatus(200)->assertJson([
            'status' => 'success',
            'message' => 'Produto criado com sucesso'
        ]);

        $this->assertDatabaseHas('products', $payload);
    }

    public function test_products_delete(): void
    {
        $product = Products::create([
            'name' => 'Produto Teste',
            'description' => 'Descrição do produto teste',
            'price' => 99.99,
            'quantity' => 10,
            'image' => 'https://via.placeholder.com/640x480.png/007711?text=aut'
        ]);

        $response = $this->delete("/api/products/{$product->id}");
        $response->dump();

        $response->assertStatus(200)->assertJson([
            'status' => 'success',
            'message' => 'Produto removido com sucesso'
        ]);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'name' => 'Produto Teste',
            'description' => 'Descrição do produto teste',
            'price' => 99.99,
            'quantity' => 10,
            'image' => 'https://via.placeholder.com/640x480.png/007711?text=aut'
        ]);
    }
}
