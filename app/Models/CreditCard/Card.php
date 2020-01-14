<?php

namespace App\Models\CreditCard;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CreditCard\Card
 *
 * @property int $id
 * @property int $user_id
 * @property string $holder_name
 * @property string $number_card
 * @property string $expire_month
 * @property string $expire_year
 * @property string $cvv_code
 * @property string|null $zip_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card whereCvvCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card whereExpireMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card whereExpireYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card whereHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card whereNumberCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard\Card whereZipCode($value)
 * @mixin \Eloquent
 * @property-write mixed $raw
 */
class Card extends Model
{
    protected $fillable = [
        'user_id','holder_name',
        'number_card','expire_month',
        'expire_year','cvv_code',
        'zip_code',''
    ];
}
