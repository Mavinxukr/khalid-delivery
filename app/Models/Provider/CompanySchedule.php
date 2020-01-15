<?php

namespace App\Models\Provider;

use Illuminate\Database\Eloquent\Model;

class CompanySchedule extends Model
{
    protected $fillable = [
        'monday','tuesday','wednesday',
        'thursday','friday','saturday',
        'sunday','provider_id'
    ];

    protected $hidden = [
        'provider_id','created_at','updated_at'
    ];

    public function company()
    {
        return $this->belongsTo(Provider::class,'provider_id');
    }
}
