<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CheckoutData;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Contracts\CartStorageInterface;

class CheckoutService
{
    public function __construct(private readonly CartStorageInterface $cartStorage) {}

    /**
     * @throws ValidationException
     */
    public function processOrder(CheckoutData $dto, int $userId): Order
    {
        $cartSession = $this->cartStorage->get();

        if (empty($cartSession)) {
            throw ValidationException::withMessages(['cart' => 'Корзина пуста']);
        }

        return DB::transaction(function () use ($dto, $userId, $cartSession) {
            // Создаем болванку заказа. Сумму пока ставим 0, потом обновим когда посчитаем
            $order = Order::create([
                'user_id' => $userId,
                'name'    => $dto->name,
                'phone'   => $dto->phone,
                'address' => $dto->address,
                'total'   => 0,
            ]);

            $totalInCents = $this->processItemsAndCalculateTotal($order, $cartSession);

            // апдейтим сумму заказа. тут ложится чистый int (в копейках)
            $order->update(['total' => $totalInCents]);

            // чистим корзину после успешного оформления
            $this->cartStorage->put([]);

            return $order;
        });
    }

    /**
     * @throws ValidationException
     */
    private function processItemsAndCalculateTotal(Order $order, array $cartSession): int
    {
        $cartSession = collect($cartSession);

        // Сортируем айдишники по порядку шоб не словить дедлок (deadlock)
        // если два юзера одновременно купят одни и те же товары
        $productIds = $cartSession->keys()->sort()->values()->all();

        // Лочим все нужные товары
        $products = Product::whereIn('id', $productIds)
            ->lockForUpdate()
            ->get()
            ->keyBy('id');

        // сумма в копейках (int)
        $totalSumInCents = 0;

        foreach ($cartSession as $productId => $quantity) {
            $product = $products->get($productId);

            $this->ensureProductIsAvailable($product, (int) $productId, (int) $quantity);

            // списываем остатки со склада
            $product->decrement('stock', $quantity);

            $order->items()->create([
                'product_id' => $product->id,
                'price_sum'  => $product->full_price, // пишем копейки в ордер
                'quantity'   => $quantity,
            ]);

            // безопасно умножаем целые числа
            $totalSumInCents += $product->full_price * $quantity;
        }

        return $totalSumInCents;
    }

    /**
     * @throws ValidationException
     */
    private function ensureProductIsAvailable(?Product $product, int $productId, int $quantity): void
    {
        if (!$product) {
            throw ValidationException::withMessages([
                'cart' => "Товар #{$productId} больше не существует.",
            ]);
        }

        if ($product->stock < $quantity) {
            throw ValidationException::withMessages([
                'cart' => "Товар {$product->name} закончился. Доступно: {$product->stock}",
            ]);
        }
    }
}
