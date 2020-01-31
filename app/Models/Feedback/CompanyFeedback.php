<?php

namespace App\Models\Feedback;

use Illuminate\Database\Eloquent\Model;

class CompanyFeedback extends Model
{
    protected $fillable = [
        'name', 'star','provider_id'
    ];
}
