<?php

namespace App\Models\Order;

use App\Models\Checkout\Checkout;
use App\Models\Feedback\FirePush;
use App\Models\PlaceService\Place;
use App\Models\Product\Product;
use App\Models\Provider\Provider;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order\Order
 *
 * @property int $id
 * @property string $name
 * @property int $product_id
 * @property string $address_to
 * @property string $time_delivery
 * @property string $status
 * @property string $quantity
 * @property string $cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereAddressTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereTimeDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $place_id
 * @property int|null $provider_id
 * @property string|null $provider_category
 * @property string|null $type_cleaning
 * @property int $interval
 * @property string|null $comment
 * @property-read \App\Models\Product\Product $product
 * @property-read \App\Models\Provider\Provider|null $provider
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereProviderCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereTypeCleaning($value)
 * @property int|null $count_clean
 * @property string|null $type
 * @property-read \App\Models\PlaceService\Place $place
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereCountClean($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereType($value)
 * @property int|null $debt
 * @property int|null $paid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereDebt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order wherePaid($value)
 * @property mixed $date_delivery
 * @property string|null $date_delivery_from
 * @property string|null $date_delivery_to
 * @property string|null $callback_time
 * @property int|null $user_id
 * @property-write mixed $date
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereCallbackTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereDateDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereDateDeliveryFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereDateDeliveryTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Order whereUserId($value)
 * @property-read \App\Models\Order\CancelOrder $cancelOrderTime
 * @property-read \App\Models\Feedback\FirePush $firePush
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product\Product[] $products
 * @property-read int|null $products_count
 * @property-write mixed $raw
 */
class Order extends Model
{
    protected $casts = [
        'date_delivery' => 'date:YYYY-MM-DD',
    ];

    protected $fillable = [
        'date_delivery','count_clean',
        'status','quantity', 'cost','provider_id',
        'type_cleaning','interval', 'comment','name',
        'place_id','paid','debt','date_delivery_from',
        'date_delivery_to','callback_time','user_id',
        'type_cleaning','product_id', 'service_received',
        'company_received', 'pre_order_id', 'initial_cost',
    ];


    protected $hidden = [
        'place_id','user_id','provider_id',
        'paid','created_at','updated_at',
        'product_id','interval','debt',
        'quantity','count_clean',
        'type_cleaning','comment','date_delivery',
        'service_received', 'company_received',
    ];


    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id','id');
    }
    public function place()
    {
        return $this->belongsTo(Place::class,'place_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function cancelOrderTime()
    {
        return $this->hasOne(CancelOrder::class);
    }

    public function firePush()
    {
        return $this->hasOne(FirePush::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class,'order_products');
    }

    public function checkout()
    {
        return $this->hasOne(Checkout::class);
    }

    public function preOrder()
    {
        return $this->belongsTo(PreOrder::class, 'pre_order_id');
    }
}
