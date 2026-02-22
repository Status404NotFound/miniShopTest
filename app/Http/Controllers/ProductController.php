<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Page /products/{id} — карточка товара
     */
    public function index(Product $product): View
    {
        $product->load('category'); // категория для карточки товара
        return view('products.show', compact('product'));
    }
}
