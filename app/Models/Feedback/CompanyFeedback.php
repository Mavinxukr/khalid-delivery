<?php

namespace App\Models\Feedback;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CompanyFeedback extends Model
{
    protected $fillable = [
        'name', 'star','provider_id','user_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
