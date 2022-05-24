<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfCartEmptyMiddleware;

class CheckoutIndexController extends Controller
{
    public function __construct()
    {
        $this->middleware(RedirectIfCartEmptyMiddleware::class);
    }

    public function __invoke()
    {
        return view('checkout');
    }
}
