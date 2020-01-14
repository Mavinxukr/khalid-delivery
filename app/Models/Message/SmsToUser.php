<?php

namespace App\Models\Message;

use App\Models\Provider\Provider;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Message\SmsToUser
 *
 * @property int $id
 * @property string $body
 * @property string|null $log
 * @property string $status
 * @property int $provider_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Provider\Provider $provider
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\SmsToUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\SmsToUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\SmsToUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\SmsToUser whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\SmsToUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\SmsToUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\SmsToUser whereLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\SmsToUser whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\SmsToUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\SmsToUser whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-write mixed $raw
 */
class SmsToUser extends Model
{
    protected $fillable = [
        'body' ,'provider_id','status','log'
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id');
    }
}
