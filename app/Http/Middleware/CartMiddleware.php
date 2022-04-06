<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Cart\Contracts\CartInterface;

class CartMiddleware
{
    protected $cart;

    public function __construct(CartInterface $cart)
    {
        $this->cart = $cart;
    }

    public function handle(Request $request, Closure $next)
    {
        if (! $this->cart->exists()) {
            $this->cart->create($request->user());
        }

        return $next($request);
    }
}
