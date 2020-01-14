<?php

namespace App\Models\Payment;

use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Provider\Provider;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Payment\Payment
 *
 * @property int $id
 * @property string $name
 * @property float|null $count
 * @property string $action
 * @property int $provider_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Provider\Provider $provider
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $product_id
 * @property-read \App\Models\Product\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment whereProductId($value)
 * @property string|null $status
 * @property int|null $order_id
 * @property-read \App\Models\Order\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment whereStatus($value)
 * @property string $type
 * @property-write mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment\Payment whereType($value)
 */
class Payment extends Model
{
    protected $fillable = [
        'name','action','count',
        'provider_id','product_id',
        'status','order_id'
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
