<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Cart\Contracts\CartInterface;

class Cart extends Component
{
    public function render(CartInterface $cart)
    {
        return view('livewire.cart', compact('cart'));
    }
}
