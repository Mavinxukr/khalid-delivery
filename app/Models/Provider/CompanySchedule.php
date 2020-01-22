<?php

namespace App\Models\Provider;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Provider\CompanySchedule
 *
 * @property int $id
 * @property int $provider_id
 * @property string $monday
 * @property string $tuesday
 * @property string $wednesday
 * @property string $thursday
 * @property string $friday
 * @property string $saturday
 * @property string $sunday
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Provider\Provider $company
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule whereFriday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule whereMonday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule whereSaturday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule whereSunday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule whereThursday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule whereTuesday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanySchedule whereWednesday($value)
 * @mixin \Eloquent
 */
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
