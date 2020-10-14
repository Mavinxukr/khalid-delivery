<?php

namespace App\Models\Reward;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reward extends Model
{
    use Notifiable;

    protected $fillable = [
        'sender_id','email' ,'using' , 'code'
    ];
}
