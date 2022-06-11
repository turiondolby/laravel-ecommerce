<?php

namespace App\Models\Presenters;

use App\Models\Order;

class OrderPresenter
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function status()
    {
        if ($this->order->status() === 'placed_at') {
            return 'Order Placed';
        }

        if ($this->order->status() === 'packaged_at') {
            return 'Order Packaged';
        }

        if ($this->order->status() === 'shipped_at') {
            return 'Order shipped';
        }

        return '';
    }
}
