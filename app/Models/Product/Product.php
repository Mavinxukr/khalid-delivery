<?php

namespace App\Models\Product;

use App\Helpers\ImageLinker;
use App\Models\Category\Category;
use App\Models\Category\ProductCategory;
use App\Models\Provider\Provider;
use App\Models\Util\Util;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Food\Menu
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $dish
 * @property float $price
 * @property string $image
 * @property mixed|null $file
 * @property int $provider_id
 * @property string $provider_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Provider\Provider $provider
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu whereDish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Menu whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $product
 * @property int $category_id
 * @property-read \App\Models\Category\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Product whereProduct($value)
 * @property string|null $chose_type
 * @property-read \App\Models\Category\ProductCategory $categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Product whereChoseType($value)
 * @property string|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Product whereType($value)
 * @property-write mixed $raw
 * @property bool $has_ingredients
 * @property int|null $parent_id
 * @property int|null $weight
 * @property bool $active
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product\Product[] $component
 * @property-read int|null $component_count
 * @property-read \App\Models\Product\Product|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Product whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Product whereHasIngredients($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Product whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product\Product whereWeight($value)
 */
class Product extends Model
{
    protected $casts = [
        'has_ingredients' => 'boolean',
        'active'          => 'boolean',
        'what_is_included' => 'array',
    ];

    protected $fillable = [
        'title','description',
        'price','image','category_id',
        'provider_id','type','parent_id',
        'weight','active', 'query', 'answer_type',
        'what_is_included', 'what_is_not_included',
        'info_pay', 'sort_most_selling', 'sort_appetizers',
        'sort_sales','rating','util_id','product_count_type'
    ];


    protected $hidden = [
        'parent_id','updated_at','created_at',
        'category_id','provider_id','pivot'
    ];

    public function getImageAttribute($value)
    {
        return  ImageLinker::linker($value);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id','id');
    }
    public function categories()
    {
        return $this->belongsTo(ProductCategory::class,'category_id','id');
    }

    public function component()
    {
        return $this->hasMany(Product::class,'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(Product::class,'parent_id');
    }

    public function utils()
    {
        return $this->belongsTo(Util::class, 'util_id');
    }

    public function queries()
    {
        return $this->hasMany(Query::class);
    }
}
