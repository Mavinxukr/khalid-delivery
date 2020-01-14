<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order\CancelOrder
 *
 * @property int $id
 * @property int $order_id
 * @property string $confirm_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-write mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\CancelOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\CancelOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\CancelOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\CancelOrder whereConfirmTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\CancelOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\CancelOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\CancelOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\CancelOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CancelOrder extends Model
{
    protected $fillable =[
        'order_id','confirm_time'
        ];
}
