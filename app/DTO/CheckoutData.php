<?php

namespace App\DTO;

class CheckoutData
{
    public function __construct(
        public string $name,
        public string $phone,
        public string $address,
    ) {}

    // создания DTO из массива
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            phone: $data['phone'],
            address: $data['address']
        );
    }
}
