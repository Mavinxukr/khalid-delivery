<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'query_id', 'title', 'price',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'query_id'
    ];

    public function forQuery()
    {
        return $this->belongsTo(Query::class);
    }
}
