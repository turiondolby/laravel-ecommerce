<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Http\Middleware\RedirectIfCartEmptyMiddleware;
use App\Cart\Exceptions\QuantityNoLongerAvailableException;

class CheckoutIndexController extends Controller
{
    public function __construct()
    {
        $this->middleware(RedirectIfCartEmptyMiddleware::class);
    }

    public function __invoke(CartInterface $cart)
    {
        try {
            $cart->verifyAvailableQuantities();
        } catch (QuantityNoLongerAvailableException $e) {
            $cart->syncAvailableQuantities();
        }

        return view('checkout');
    }
}
