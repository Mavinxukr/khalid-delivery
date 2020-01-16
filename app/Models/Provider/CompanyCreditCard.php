<?php

namespace App\Models\Provider;

use Illuminate\Database\Eloquent\Model;

class CompanyCreditCard extends Model
{
    protected $fillable = [
        'provider_id','holder_name',
        'number_card','expire_month',
        'expire_year','cvv_code',
        'zip_code',''
    ];

    protected $hidden = [
        'created_at','updated_at'
    ];


    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id');
    }
}
