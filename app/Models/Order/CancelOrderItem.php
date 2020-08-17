<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class CancelOrderItem extends Model
{
    protected $fillable = [
        'order_id', 'description', 'image'
    ];
}
