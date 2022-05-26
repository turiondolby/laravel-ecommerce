<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Cart\Exceptions\QuantityNoLongerAvailableException;

class CartIndexController extends Controller
{
    public function __invoke(CartInterface $cart)
    {
        try {
            $cart->verifyAvailableQuantities();
        } catch (QuantityNoLongerAvailableException $e) {
            session()->flash('notification', 'Some items or quantities in your cart have become unavailable.');

            $cart->syncAvailableQuantities();
        }

        return view('cart.index');
    }
}
