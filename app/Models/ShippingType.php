<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingType extends Model
{
    use HasFactory;

    public function formattedPrice()
    {
        return money($this->price);
    }
}
