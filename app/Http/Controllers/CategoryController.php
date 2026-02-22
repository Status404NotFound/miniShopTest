<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Page /category/id — каталог
     */
    public function index(Request $request, Category $category): View
    {
        $categories = Category::all();

        $products = $category->products()
            ->filterPrices($request->min_price, $request->max_price)
            ->paginate(2)
            ->withQueryString();

        return view('category.show', compact('category', 'categories', 'products'));
    }
}
