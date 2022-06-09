<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdatedMail;

class OrderObserver
{
    public function updated(Order $order)
    {
        $originalOrder = new Order(
            collect($order->getOriginal())
                ->only($order->statuses)
                ->toArray()
        );


        $filledStatuses = collect($order->getDirty())
            ->only($order->statuses)
            ->filter(function ($status) {
                return filled($status);
            });

        if ($originalOrder->status() !== $order->status() && $filledStatuses->count()) {
            Mail::to($order->user)->send(new OrderStatusUpdatedMail($order));
        }
    }
}
