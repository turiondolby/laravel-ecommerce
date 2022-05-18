<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Cart\Contracts\CartInterface;

class Checkout extends Component
{
    public function render(CartInterface $cart)
    {
        return view('livewire.checkout', [
            'cart' => $cart
        ]);
    }
}
