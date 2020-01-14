<?php

namespace App\Models\Feedback;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Feedback\FeedbackTemplate
 *
 * @property int $id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-write mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FeedbackTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FeedbackTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FeedbackTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FeedbackTemplate whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FeedbackTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FeedbackTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback\FeedbackTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FeedbackTemplate extends Model
{
    protected  $fillable = [
        'body'
    ];
    protected $table = 'templates';
}
