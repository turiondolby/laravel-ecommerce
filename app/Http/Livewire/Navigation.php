<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Cart\Contracts\CartInterface;

class Navigation extends Component
{
    public $searchQuery;

    protected $listeners = [
        'cart.updated' => '$refresh'
    ];

    public function clearSearch()
    {
        $this->searchQuery = '';
    }

    public function getCartProperty(CartInterface $cart)
    {
        return $cart;
    }

    public function render()
    {
        $products = Product::search($this->searchQuery)->get();

        return view('livewire.navigation', [
            'products' => $products
        ]);
    }
}
