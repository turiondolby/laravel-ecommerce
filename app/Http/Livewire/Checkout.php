<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\ShippingType;
use App\Mail\OrderCreatedMail;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Mail;
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

        if ($this->getPaymentIntent($cart)->status !== 'succeeded') {
            $this->dispatchBrowserEvent('notification', [
                'body' => 'Your payment failed.'
            ]);

            return;
        }

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

        $order->variations()->attach(
            $cart->contents()->mapWithKeys(function ($variation) {
                return [
                    $variation->id => [
                        'quantity' => $variation->pivot->quantity
                    ]
                ];
            })->toArray()
        );

        $cart->contents()->each(function ($variation) {
            $variation->stocks()->create([
                'amount' => 0 - $variation->pivot->quantity,
            ]);
        });

        $cart->removeAll();

        Mail::to($order->email)->send(new OrderCreatedMail($order));

        $cart->destroy();

        if (! auth()->user()) {
            return redirect()->route('orders.confirmation', $order);
        }

        return redirect()->route('orders');
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

    public function getPaymentIntent(CartInterface $cart)
    {
        if ($cart->hasPaymentIntent()) {
            $paymentIntent = app('stripe')->paymentIntents->retrieve($cart->getPaymentIntentId());

            if ($paymentIntent->status !== 'succeeded') {
                app('stripe')->paymentIntents->update($cart->getPaymentIntentId(), [
                    'amount' => (int)$this->total,
                ]);
            }

            return $paymentIntent;
        }


        $paymentIntent = app('stripe')->paymentIntents->create([
            'amount' => (int)$this->total,
            'currency' => 'usd',
            'setup_future_usage' => 'on_session',
        ]);

        $cart->updatePaymentIntentId($paymentIntent->id);

        return $paymentIntent;
    }

    public function callValidate()
    {
        $this->validate();
    }

    public function getErrorCount()
    {
        return $this->getErrorBag()->count();
    }

    public function render(CartInterface $cart)
    {
        return view('livewire.checkout', [
            'cart' => $cart,
            'paymentIntent' => $this->getPaymentIntent($cart),
        ]);
    }
}
