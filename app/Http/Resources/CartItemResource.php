<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this['id'],
            'name'     => $this['name'],
            'price'    => $this['price'] / 100, //конфертируем цену для фронта
            'quantity' => $this['quantity'],
            'stock'    => $this['stock'],
        ];
    }
}
