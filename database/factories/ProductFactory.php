<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(), // Создаст категорию, если не передана
            'name' => ucfirst($this->faker->words(3, true)),
            'description' => $this->faker->realText(200),
            // Генерируем цену от 1.00 до 300.00 (в копейках)
            'full_price' => $this->faker->randomFloat(2,100, 30000),
            // 10% шанс, что товара нет в наличии
            'stock' => $this->faker->boolean(90) ? $this->faker->numberBetween(1, 50) : 0,
        ];
    }
}
