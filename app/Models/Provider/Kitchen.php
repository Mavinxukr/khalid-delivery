<?php

namespace App\Models\Provider;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Provider\Kitchen
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Kitchen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Kitchen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Kitchen query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Kitchen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Kitchen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Kitchen whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Kitchen whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Kitchen extends Model
{
    protected $fillable = ['name'];

    protected $hidden = ['created_at','updated_at'];
}
