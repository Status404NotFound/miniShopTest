<?php

namespace App\Contracts;

interface CartStorageInterface
{
    public function get(): array;
    public function put(array $cart): void;
    public function forget(): void;
}
