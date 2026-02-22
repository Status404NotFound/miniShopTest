<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CheckoutService;
use App\DTO\CheckoutData;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function __construct(private CheckoutService $checkoutService) {}

    public function index(): View
    {
        $orders = auth()->user()->orders()->orderByDesc('created_at')->get();
        return view('orders.index', compact('orders'));
    }

    public function create(): View|RedirectResponse
    {
        if (empty(session('cart', []))) {
            return redirect('/')->with('error', 'Ваша корзина пуста');
        }

        return view('orders.checkout');
    }

    /**
     * @throws ValidationException
     */
    public function store(CheckoutRequest $request): RedirectResponse
    {
        $dto = CheckoutData::fromArray($request->validated());

        $this->checkoutService->processOrder($dto, auth()->id());

        return redirect()->route('orders.index')->with('success', 'Заказ успешно оформлен!');
    }
}
