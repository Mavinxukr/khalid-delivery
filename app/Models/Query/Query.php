<?php

namespace App\Models\Query;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $fillable = [
        'parent_id', 'value', 'type'
    ];

    protected $hidden = [
        'parent_id', 'updated_at', 'created_at', 'type',
    ];

    public function answer()
    {
        return $this->hasMany(Query::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Query::class, 'parent_id');
    }
}
