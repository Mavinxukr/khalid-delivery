<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderLocationHistory extends Model
{
    protected $fillable = [
        'order_id', 'user_id', 'lat', 'lng'
    ];
}
