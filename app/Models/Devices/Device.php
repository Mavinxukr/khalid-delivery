<?php

namespace App\Models\Devices;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public $fillable = [
        'id', 'token', 'user_id', 'service'
    ];
}
