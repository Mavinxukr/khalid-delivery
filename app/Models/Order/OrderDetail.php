<?php

namespace App\Models\Order;

use App\Models\Product\Answer;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'pre_order_id', 'answer_id', 'query_id',
    ];

    public function preOrder()
    {
        return $this->belongsTo(PreOrder::class, 'pre_order_id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id', 'id');
    }
}
