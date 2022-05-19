<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ShippingType;
use App\Cart\Contracts\CartInterface;

class Checkout extends Component
{
    public $shippingTypes;
    public $shippingTypeId;

    public function mount()
    {
        $this->shippingTypes = ShippingType::orderBy('price')->get();

        $this->shippingTypeId = $this->shippingTypes->first()->id;
    }

    public function getShippingTypeProperty()
    {
        return $this->shippingTypes->find($this->shippingTypeId);
    }

    public function render(CartInterface $cart)
    {
        return view('livewire.checkout', [
            'cart' => $cart,
        ]);
    }
}
