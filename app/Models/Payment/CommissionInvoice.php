<?php

namespace App\Models\Payment;

use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Provider\Provider;
use Illuminate\Database\Eloquent\Model;

class CommissionInvoice extends Model
{
    protected $fillable = [
        'name','action','count',
        'provider_id','product_id',
        'status', 'deadline'
    ];

    protected $casts = [
        'deadline' => 'date'
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class,'invoice_order', 'invoice_id', 'order_id');
    }
}
