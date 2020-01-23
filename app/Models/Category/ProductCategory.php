<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category\ProductCategory
 *
 * @property int $id
 * @property int $active
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\ProductCategory whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\ProductCategory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\ProductCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-write mixed $raw
 * @property string|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\ProductCategory whereImage($value)
 */
class ProductCategory extends Model
{
    protected $fillable = [
        'id', 'active','image',
        'cause','type'
    ];
}
