<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $fillable = [
        'title', 'product_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'product_id'
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
