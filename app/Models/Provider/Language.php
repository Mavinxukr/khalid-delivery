<?php

namespace App\Models\Provider;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Provider\Language
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Provider\Language whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    protected $fillable =  ['name'];
    protected $hidden = [
        'created_at','updated_at','pivot'
    ];
}
