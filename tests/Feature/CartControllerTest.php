<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_empty_cart(): void
    {
        $response = $this->getJson(route('cart.index'));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => []
            ]);
    }

    public function test_can_add_item_to_cart(): void
    {
        $product = Product::factory()->create(['stock' => 10, 'full_price' => 1500]);

        $response = $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Товар добавлен в корзину'
            ]);

        // Проверяем что в структуре ответа есть наш товар
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals($product->id, $response->json('data.0.id'));
    }

    public function test_can_remove_item_from_cart(): void
    {
        $product = Product::factory()->create(['stock' => 10]);

        // добавляем товар
        $this->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        // удаляем товар
        $response = $this->postJson(route('cart.remove'), [
            'product_id' => $product->id
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Товар удален из корзины',
                'data' => []
            ]);
    }
}
