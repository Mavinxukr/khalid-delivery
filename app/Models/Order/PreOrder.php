<?php

namespace App\Models\Order;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PreOrder extends Model
{
    protected $fillable = [
        'user_id', 'price', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'pre_order_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class,'pre_order_id');
    }
}
