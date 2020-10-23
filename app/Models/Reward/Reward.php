<?php

namespace App\Models\Reward;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reward extends Model
{
    use Notifiable;

    protected $fillable = [
        'sender_id','used' , 'code', 'recipient_email'
    ];

    protected $casts = [
        'used' => 'boolean'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class,'recipient_id');
    }


}
