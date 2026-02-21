<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'full_price',
        'stock'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilterPrices($query, $minPrice, $maxPrice): void
    {
        $query->when($minPrice, fn($q, $min) => $q->where('full_price', '>=', (int) round((float) $min * 100)))
            ->when($maxPrice, fn($q, $max) => $q->where('full_price', '<=', (int) round((float) $max * 100)));
    }

    // конвертации цены для фронта
    public function getPriceString(): string
    {
        return number_format($this->full_price / 100, 2, '.', ' ');
    }
}
