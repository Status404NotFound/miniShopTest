<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_checkout(): void
    {
        $response = $this->get(route('checkout.create'));

        // Гостя должно кидать на страницу логина
        $response->assertRedirect(route('login'));
    }

    public function test_user_cannot_checkout_with_empty_cart(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('checkout.create'));

        // пользователя с пустой корзиной должно кидать на главную
        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Ваша корзина пуста');
    }

    public function test_user_can_submit_order(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 5, 'full_price' => 1000]);

        // добавление товара в корзину
        $this->withSession(['cart' => [$product->id => 2]]);

        // оформление заказа
        $response = $this->actingAs($user)->post(route('orders.store'), [
            'name' => 'Иван Иванов',
            'phone' => '+1234567890',
            'address' => 'ул. Пушкина, дом Колотушкина'
        ]);

        // проверяем редирект на список заказов
        $response->assertRedirect(route('orders.index'));
        $response->assertSessionHas('success', 'Заказ успешно оформлен!');

        // проверяем что заказ реально появился в БД
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'name' => 'Иван Иванов',
            'total' => 2000
        ]);
    }
}
