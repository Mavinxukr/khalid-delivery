<?php

namespace App\Models\Checkout;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected  $fillable = [
        'card_token','source_id','source_type',
        'source_scheme','source_card_type',
        'source_card_category','source_issuer',
        'source_issuer_country','checkout_id',
        'checkout_action_id','status','sum',
        'currency','user_id', 'order_id'
    ];

}
