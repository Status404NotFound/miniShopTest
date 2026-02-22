<?php

namespace App\Services\Cart;

use App\Contracts\CartStorageInterface;

class SessionCartStorage implements CartStorageInterface
{
    private string $key = 'cart';

    public function get(): array
    {
        return session()->get($this->key, []);
    }

    public function put(array $cart): void
    {
        session()->put($this->key, $cart);
    }

    public function forget(): void
    {
        session()->forget($this->key);
    }
}
