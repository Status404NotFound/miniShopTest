<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\CartStorageInterface;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function __construct(private readonly CartStorageInterface $storage) {}

    public function getCartItems(): Collection
    {
        // Берем сессию и сразу оборачиваем в колекцию.
        $cartSession = collect($this->storage->get());

        if ($cartSession->isEmpty()) {
            return collect();
        }

        // тянем все товары одним запросом, keyBy нужен чтоб потом быстро искать
        $products = Product::whereIn('id', $cartSession->keys())->get()->keyBy('id');

        // ложим товары в коржину
        return $cartSession->map(function (int $quantity, int $productId) use ($products) {
            $product = $products->get($productId);

            // Если товар удалили из базы пока он лежал в корзине (редко но бывает)
            if (!$product) {
                return null;
            }

            return [
                'id'       => $product->id,
                'name'     => $product->name,
                // отдаем сырые копейки.
                'price'    => $product->full_price,
                'quantity' => $quantity,
                'stock'    => $product->stock,
            ];
        })->filter()->values();
    }

    /**
     * @throws ValidationException
     */
    public function add(int $productId, int $quantity = 1): void
    {
        $cart = collect($this->storage->get());

        $newQuantity = $cart->get($productId, 0) + $quantity;

        $product = Product::findOrFail($productId);

        if ($newQuantity > $product->stock) {
            throw ValidationException::withMessages([
                'cart' => "Недостаточно товара на складе. В наличии: {$product->stock} шт.",
            ]);
        }

        $cart->put($productId, $newQuantity);

        // сохраняем обратно.
        $this->storage->put($cart->toArray());
    }

    public function remove(int $productId): void
    {
        $cart = collect($this->storage->get());

        $cart->forget($productId);

        $this->storage->put($cart->toArray());
    }
}
