<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ShippingType;
use App\Cart\Contracts\CartInterface;

class Checkout extends Component
{
    public $shippingTypes;

    public $shippingTypeId;

    public $accountForm = [
      'email' => ''
    ];

    protected $validationAttributes = [
        'accountForm.email' => 'email address',
    ];

    protected $messages = [
        'accountForm.email.unique' => 'Seems you already have an account. Please sign in to place an order.',
    ];

    public function rules()
    {
        return [
            'accountForm.email' => 'required|email|max:255|unique:users,email' . (auth()->user() ? ',' . auth()->id() : '')
        ];
    }

    public function checkout()
    {
        $this->validate();

        dd('create order');

        //
    }

    public function mount()
    {
        $this->shippingTypes = ShippingType::orderBy('price')->get();

        $this->shippingTypeId = $this->shippingTypes->first()->id;

        if ($user = auth()->user()) {
            $this->accountForm['email'] = $user->email;
        }
    }

    public function getShippingTypeProperty()
    {
        return $this->shippingTypes->find($this->shippingTypeId);
    }

    public function getTotalProperty(CartInterface $cart)
    {
        return $cart->subtotal() + $this->shippingType->price;
    }

    public function render(CartInterface $cart)
    {
        return view('livewire.checkout', [
            'cart' => $cart,
        ]);
    }
}
