<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderIndexController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function __invoke(Request $request)
    {
        $orders = $request->user()->orders()->latest()->get();
        return view('orders.index', compact('orders'));
    }
}
