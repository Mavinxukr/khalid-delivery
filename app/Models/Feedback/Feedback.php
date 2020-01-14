<?php

namespace App\Models\Feedback;

use App\Models\Provider\Provider;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Feedback\Feedback
 *
 * @property int $id
 * @property string $comment
 * @property int $order_id
 * @property int $user_id
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-write mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\Feedback whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\Feedback whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\Feedback whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\Feedback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\Feedback whereUserId($value)
 * @mixin \Eloquent
 */
class Feedback extends Model
{
    protected $fillable = [
        'comment', 'user_id','order_id',
        'company_id'
    ];

    protected $hidden = [
        'order_id','user_id','company_id',
        'created_at','updated_at'
    ];

    public function company()
    {
        return $this->belongsTo(Provider::class,'company_id');
    }
}
