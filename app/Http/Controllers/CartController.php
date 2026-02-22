<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\RemoveFromCartRequest;
use App\Http\Resources\CartItemResource;
use App\Services\CartService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly CartService $cartService) {}

    public function index(): JsonResponse
    {
        $items = $this->cartService->getCartItems();
        return $this->successResponse(CartItemResource::collection($items));
    }

    public function add(AddToCartRequest $request): JsonResponse
    {
        $this->cartService->add(
            $request->validated('product_id'),
            $request->validated('quantity')
        );

        $items = $this->cartService->getCartItems();

        return $this->successResponse(CartItemResource::collection($items), 'Товар добавлен в корзину');
    }

    public function remove(RemoveFromCartRequest $request): JsonResponse
    {
        $this->cartService->remove($request->validated('product_id'));

        $items = $this->cartService->getCartItems();

        return $this->successResponse(CartItemResource::collection($items), 'Товар удален из корзины');
    }
}
