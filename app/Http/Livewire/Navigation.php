<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Cart\Contracts\CartInterface;

class Navigation extends Component
{
    protected $listeners = [
        'cart.updated' => '$refresh'
    ];

    public function getCartProperty(CartInterface $cart)
    {
        return $cart;
    }

    public function render()
    {
        return view('livewire.navigation');
    }
}
