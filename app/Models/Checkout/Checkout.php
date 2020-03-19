<?php

namespace App\Models\Checkout;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected  $fillable = [
      'status','sum', 'message',
        'currency','user_id', 'order_id',
        'transaction_id'
    ];

}
