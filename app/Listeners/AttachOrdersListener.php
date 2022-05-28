<?php

namespace App\Listeners;

use App\Models\Order;
use Illuminate\Auth\Events\Registered;

class AttachOrdersListener
{
    public function __construct()
    {
        //
    }

    public function handle(Registered $event)
    {
        Order::where('email', $event->user->email)->get()->each(function ($order) use ($event) {
            $order->user()->associate($event->user);
            $order->save();
        });
    }
}
