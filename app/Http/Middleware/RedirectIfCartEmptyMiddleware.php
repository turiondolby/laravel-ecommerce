<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Cart\Contracts\CartInterface;

class RedirectIfCartEmptyMiddleware
{
    protected $cart;

    public function __construct(CartInterface $cart)
    {
        $this->cart = $cart;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart');
        }

        return $next($request);
    }
}
