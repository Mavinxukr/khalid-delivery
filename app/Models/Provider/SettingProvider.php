<?php

namespace App\Models\Provider;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Provider\SettingProvider
 *
 * @property int $id
 * @property int $provider_id
 * @property string $kitchen
 * @property string $time_delivery_mean
 * @property string $min_order
 * @property string $delivery_fee
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $schedule
 * @property-write mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider whereDeliveryFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider whereKitchen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider whereMinOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider whereSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider whereTimeDeliveryMean($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $tags
 * @property string $rating
 * @property string $price_rating
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider wherePriceRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\SettingProvider whereTags($value)
 */
class SettingProvider extends Model
{

}
