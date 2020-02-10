<?php

namespace App\Models\Provider;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Provider\CompanyCreditCard
 *
 * @property int $id
 * @property int $provider_id
 * @property string $holder_name
 * @property string $number_card
 * @property string $expire_month
 * @property string $expire_year
 * @property string $cvv_code
 * @property string|null $zip_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Provider\Provider $provider
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard whereCvvCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard whereExpireMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard whereExpireYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard whereHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard whereNumberCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\CompanyCreditCard whereZipCode($value)
 * @mixin \Eloquent
 */
class CompanyCreditCard extends Model
{
    protected $fillable = [
        'provider_id','number_card','name_company',
        'address_company','account_number_company',
        'bank_name_company','iban_number_company',
        'swift_number_company'
    ];

    protected $hidden = [
        'created_at','updated_at','provider_id'
    ];


    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id');
    }
}
