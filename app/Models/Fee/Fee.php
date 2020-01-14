<?php

namespace App\Models\Fee;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Fee\Fee
 *
 * @property int $id
 * @property string $name
 * @property int $count
 * @property int $active
 * @property mixed $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fee\Fee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fee\Fee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fee\Fee query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fee\Fee whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fee\Fee whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fee\Fee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fee\Fee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fee\Fee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fee\Fee whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fee\Fee whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-write mixed $raw
 */
class Fee extends Model
{
    protected $casts = [
        'time'  => 'datetime:YYYY-MM-DD HH:mm:ss',
    ];
}
