<?php

namespace App\Http\Controllers;

class CheckoutIndexController extends Controller
{
    public function __invoke()
    {
        return view('checkout');
    }
}
