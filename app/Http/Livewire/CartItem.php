<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CartItem extends Component
{
    public $variation;

    public function render()
    {
        return view('livewire.cart-item');
    }
}
