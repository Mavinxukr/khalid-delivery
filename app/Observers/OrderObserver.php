<?php

namespace App\Observers;

use App\Models\Fee\Fee;
use App\Models\Order\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    public function updated(Order $order)
    {
        if(is_null($order->service_received)){
            $order->service_received = $order->cost / 100 * $this->getFee($order, 'received');
            $order->company_received = $order->cost / 100 * (100 - $this->getFee($order, 'received'));
            $order->save();
        }
    }

    private function getFee($order, $name){
        return Fee::whereName($order->provider_category . '_' . $name)->first()->count;
    }
}
