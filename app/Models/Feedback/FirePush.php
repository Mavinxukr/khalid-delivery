<?php

namespace App\Models\Feedback;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Feedback\FirePush
 *
 * @property int $id
 * @property string $time
 * @property int $order_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date
 * @property string|null $status
 * @property-write mixed $raw
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FirePush newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FirePush newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FirePush query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FirePush whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FirePush whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FirePush whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FirePush whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FirePush whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FirePush whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FirePush whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FirePush whereUserId($value)
 * @mixin \Eloquent
 */
class FirePush extends Model
{
    protected  $fillable = [
        'time','order_id','user_id',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
