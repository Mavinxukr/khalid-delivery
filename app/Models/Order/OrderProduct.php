<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order\OrderProduct
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-write mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\OrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\OrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\OrderProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\OrderProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\OrderProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\OrderProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\OrderProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $quantity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\OrderProduct whereQuantity($value)
 */
class OrderProduct extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'canceled'
    ];
}
