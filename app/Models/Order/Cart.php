<?php

namespace App\Models\Order;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order\Cart
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Cart whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Cart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\Cart whereUserId($value)
 * @mixin \Eloquent
 */
class Cart extends Model
{
    protected $fillable = [
        'user_id','product_id','quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
