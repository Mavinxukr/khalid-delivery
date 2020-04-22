<?php

namespace App\Models\Transactions;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $fillable = [
        'id','status','response_code','transaction_id','order_id',
        'auth_code','transaction_title','amount','currency',
        'net_amount','net_amount_currency','net_amount_credited',
        'net_amount_credited_currency','transaction_datetime',
        'force_accept_datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
