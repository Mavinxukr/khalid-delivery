<?php

namespace App\Models\FAQ;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'parent_id', 'value', 'type'
    ];

    protected $hidden = [
        'parent_id', 'updated_at', 'created_at', 'type',
    ];

    public function answer()
    {
        return $this->hasOne(Faq::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Faq::class, 'parent_id');
    }
}
