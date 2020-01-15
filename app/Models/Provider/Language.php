<?php

namespace App\Models\Provider;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable =  ['name'];
    protected $hidden = [
        'created_at','updated_at','pivot'
    ];
}
