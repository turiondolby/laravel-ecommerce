<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\ShippingType;
use App\Models\ShippingAddress;
use App\Cart\Contracts\CartInterface;

class Checkout extends Component
{
    public $shippingTypes;

    public $shippingTypeId;

    public $shippingAddress;

    public $userShippingAddressId;

    public $accountForm = [
      'email' => ''
    ];

    public $shippingForm = [
        'address' => '',
        'city' => '',
        'postcode' => '',
    ];

    protected $validationAttributes = [
        'accountForm.email' => 'email address',
        'shippingForm.address' => 'shipping address',
        'shippingForm.city' => 'shipping city',
        'shippingForm.postcode' => 'shipping postal code',
    ];

    protected $messages = [
        'accountForm.email.unique' => 'Seems you already have an account. Please sign in to place an order.',
        'shippingForm.address.required' => 'Your :attribute is required.',
    ];

    public function rules()
    {
        return [
            'accountForm.email' => 'required|email|max:255|unique:users,email' . (auth()->user() ? ',' . auth()->id() : ''),
            'shippingForm.address' => 'required|max:255',
            'shippingForm.city' => 'required|max:255',
            'shippingForm.postcode' => 'required|max:255',
            'shippingTypeId' => 'required|exists:shipping_types,id',
        ];
    }

    public function updatedUserShippingAddressId($id)
    {
        if (! $id) {
            return;
        }

        $this->shippingForm = $this->userShippingAddresses->find($id)
            ->only('address', 'city', 'postcode');
    }

    public function getUserShippingAddressesProperty()
    {
        return optional(auth()->user())->shippingAddresses;
    }

    public function checkout(CartInterface $cart)
    {
        $this->validate();

        $this->shippingAddress = ShippingAddress::query();

        if (auth()->user()) {
            $this->shippingAddress = $this->shippingAddress->whereBelongsTo(auth()->user());
        }

        $this->shippingAddress = $this->shippingAddress->firstOrCreate($this->shippingForm);

        optional($this->shippingAddress)
            ->user()
            ->associate(auth()->user())
            ->save();

        $order = Order::make(array_merge($this->accountForm, [
            'subtotal' => $cart->subtotal()
        ]));

        $order->user()->associate(auth()->user());

        $order->shippingType()->associate($this->shippingType);
        $order->shippingAddress()->associate($this->shippingAddress);

        $order->save();
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
