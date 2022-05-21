<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'city',
        'postcode',
    ];

    public function formattedAddress()
    {
        return sprintf('%s, %s, %s',
            $this->address,
            $this->city,
            $this->postcode
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
