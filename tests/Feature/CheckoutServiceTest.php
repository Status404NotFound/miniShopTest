<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\DTO\CheckoutData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_checkout_process(): void
    {
        $user = User::factory()->create();

        // задаем цену для теста строго в инте
        $product = Product::factory()->create(['stock' => 10, 'full_price' => 1000]);

        $cartService = app(CartService::class);
        $cartService->add($product->id, 2);

        $checkoutService = app(CheckoutService::class);
        $dto = new CheckoutData('Иван Иванов', '1234567890', 'ул. Тестовая, 1');

        $order = $checkoutService->processOrder($dto, $user->id);

        // Чеккаем, что в БД легла правильная сумма в копейках
        $this->assertDatabaseHas('orders', [
            'id'      => $order->id,
            'user_id' => $user->id,
            'total'   => 2000,
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => 2,
            'price_sum'  => 1000,
        ]);

        // Убеждаемся что остаток корректно списался со склада
        $this->assertEquals(8, $product->fresh()->stock);

        // После успешного заказа корзина должна быть чистой
        $this->assertTrue($cartService->getCartItems()->isEmpty());
    }

    public function test_cannot_checkout_with_empty_cart(): void
    {
        $user = User::factory()->create();
        $checkoutService = app(CheckoutService::class);
        $dto = new CheckoutData('Иван Иванов', '1234567890', 'ул. Тестовая, 1');

        // Ждем ошибку, если кто-то дернет метод оформления с пустой корзиной
        $this->expectException(ValidationException::class);

        $checkoutService->processOrder($dto, $user->id);
    }
}
