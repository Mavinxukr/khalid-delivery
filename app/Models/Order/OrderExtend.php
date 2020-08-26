<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderExtend extends Model
{
    protected $fillable = [
        'order_id', 'extend_to',
        'extend_from', 'reason',
        'accepted', 'cost',
        'service_received', 'company_received', 'initial_cost',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'initial_cost', 'service_received', 'company_received',
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
