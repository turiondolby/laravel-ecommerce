<?php

namespace App\Http\Controllers;

class CartIndexController extends Controller
{
    public function __invoke()
    {
        return view('cart.index');
    }
}
