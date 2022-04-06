<?php

namespace App\Cart;

use App\Models\User;
use App\Models\Cart as ModelsCart;
use App\Cart\Contracts\CartInterface;
use Illuminate\Session\SessionManager;

class Cart implements CartInterface
{
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

}
