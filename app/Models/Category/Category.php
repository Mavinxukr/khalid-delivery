<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category\Category
 *
 * @property int $id
 * @property int $active
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Category whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-write mixed $raw
 */
class Category extends Model
{
    protected $fillable = [
      'active','type'
    ];

}
