<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_item_to_cart(): void
    {
        $product = Product::factory()->create(['stock' => 10]);

        $cartService = app(CartService::class);
        $cartService->add($product->id, 2);

        $items = $cartService->getCartItems();

        // ищем нужный товар
        $cartItem = $items->firstWhere('id', $product->id);

        $this->assertNotNull($cartItem);
        $this->assertEquals(2, $cartItem['quantity']);
    }

    public function test_cannot_add_more_than_stock(): void
    {
        $product = Product::factory()->create(['stock' => 5]);
        $cartService = app(CartService::class);

        // Ждем эксепшен, если юзер пытается добавить больше, чем есть на складе
        $this->expectException(ValidationException::class);

        $cartService->add($product->id, 6);
    }

    public function test_can_remove_item_from_cart(): void
    {
        $product = Product::factory()->create(['stock' => 10]);
        $cartService = app(CartService::class);

        $cartService->add($product->id, 2);
        $this->assertFalse($cartService->getCartItems()->isEmpty());

        $cartService->remove($product->id);

        // Проверяем метод isEmpty у коллекции, чтобы убедиться что товар удалился
        $this->assertTrue($cartService->getCartItems()->isEmpty());
    }
}
