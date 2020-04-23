<?php

namespace App\Models\Checkout;

use App\Models\Order\Order;
use App\Nova\Resources\Transactions\Transaction;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected  $fillable = [
      'status','sum', 'message',
        'currency','user_id', 'order_id',
        'transaction_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'order_id', 'order_id');
    }

}
