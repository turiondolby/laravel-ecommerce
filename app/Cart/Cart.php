<?php

namespace App\Cart;

use App\Models\User;
use App\Models\Variation;
use App\Models\Cart as ModelsCart;
use App\Cart\Contracts\CartInterface;
use Illuminate\Session\SessionManager;

class Cart implements CartInterface
{
    protected $instance;
    protected $session;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    public function exists()
    {
        return $this->session->has(config('cart.session.key'));
    }

    public function create(?User $user = null)
    {
        $instance = ModelsCart::make();

        if ($user) {
            $instance->user()->associate($user);
        }

        $instance->save();

        $this->session->put(config('cart.session.key'), $instance->uuid);
    }

    public function contents()
    {
        return $this->instance()->variations;
    }

    public function contentsCount()
    {
        return $this->contents()->count();
    }

    public function getVariation(Variation $variation)
    {
        return $this->instance()->variations->find($variation->id);
    }

    protected function instance()
    {
        if ($this->instance) {
            return $this->instance;
        }

        return ModelsCart::query()
            ->with(
                'variations.product',
                'variations.ancestorsAndSelf',
                'variations.descendantsAndSelf.stocks',
                'variations.media'
            )
            ->whereUuid($this->session->get(config('cart.session.key')))
            ->first();
    }

    public function add(Variation $variation, $quantity = 1)
    {
        if ($existingVariation = $this->getVariation($variation)) {
            $quantity += $existingVariation->pivot->quantity;
        }

        $this->instance()->variations()->syncWithoutDetaching([
            $variation->id => [
                'quantity' => min($quantity, $variation->stockCount())
            ]
        ]);
    }

    public function changeQuantity(Variation $variation, $quantity)
    {
        $this->instance()->variations()->updateExistingPivot($variation->id, [
            'quantity' => min($quantity, $variation->stockCount())
        ]);
    }

    public function remove(Variation $variation)
    {
        $this->instance()->variations()->detach($variation);
    }

    public function isEmpty()
    {
        return $this->contentsCount() === 0;
    }

    public function subtotal()
    {
        return $this->instance()->variations
            ->reduce(function ($carry, $variation) {
                return $carry + ($variation->price * $variation->pivot->quantity);
            });
    }

    public function formattedSubtotal()
    {
        return money($this->subtotal());
    }

}
