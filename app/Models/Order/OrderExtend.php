<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderExtend extends Model
{
    protected $fillable = [
        'order_id', 'extend_to', 'extend_from', 'reason', 'accepted',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function files()
    {
        return $this->hasMany(OrderExtendFile::class);
    }
}
