<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderConfirmationIndexController extends Controller
{
    public function __invoke(Order $order)
    {
        return view('orders.confirmation', [
            'order' => $order
        ]);
    }
}
