<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class OrderExtendFile extends Model
{
    protected $fillable = [
        'link'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
