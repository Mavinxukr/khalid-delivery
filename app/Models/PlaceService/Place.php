<?php

namespace App\Models\PlaceService;

use App\Models\Order\Order;
use App\Models\Provider\Provider;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PlaceService\Place
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $country
 * @property string|null $latitude
 * @property string|null $longitude
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place wherePostalCode($value)
 * @property-write mixed $raw
 * @property string $provider_type
 * @property int $provider_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PlaceService\Place whereProviderType($value)
 */
class Place extends Model
{
    protected $fillable = [
        'name', 'user_id','address',
        'city','postal_code','country',
        'latitude','longitude','provider_type',
        'provider_id'
    ];


    protected $hidden = [
        "created_at", "updated_at","user_id",'provider_type',
        'provider_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Provider::class,'provider_id');
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
