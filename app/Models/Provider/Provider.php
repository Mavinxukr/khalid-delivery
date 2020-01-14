<?php

namespace App\Models\Provider;

use App\Models\Category\Category;
use App\Models\Payment\Payment;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Provider\Provider
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property float $balance
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Payment\Payment $payment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $phone_number
 * @property int $active
 * @property int $category_id
 * @property-read \App\Models\Category\Category $categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Provider wherePhoneNumber($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product\Product[] $product
 * @property-read int|null $product_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product\Product[] $productTop
 * @property-read int|null $product_top_count
 * @property-read \App\Models\Provider\SettingProvider $providerSetting
 * @property-write mixed $raw
 */
class Provider extends Model
{
    protected $fillable = [
        'balance','category_id'
    ];

    protected $hidden = [
        'balance','updated_at','created_at',
        'active','image','phone_number',
        'category_id'
    ];
    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id','provider_id','payment_provider');

    }
    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function providerSetting()
    {
        return $this->hasOne(SettingProvider::class);
    }

    public function productTop()
    {
        return $this->hasMany(Product::class,'provider_id')
            ->orderBy('id','DESC')
            ->take(3);
    }

    public function product()
    {
        return $this->hasMany(Product::class,'provider_id');
    }


}
