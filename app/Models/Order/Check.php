<?php

namespace App\Models\Order;

use App\Helpers\ImageLinker;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    public $fillable = [
        'id', 'order_id', 'image'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getImageAttribute($value)
    {
        return  ImageLinker::linker($value);
    }
}
