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

        if($order->debt != $order->service_received){
            $order->debt = $order->service_received;
            $order->save();
        }

        if(!is_null($order->preOrder) &&
            !is_null($order->status) &&
            $order->preOrder->status != $order->status){
                $order->preOrder()->update(['status' => $order->status]);
        }
    }

    private function getFee($order, $name){
        return Fee::whereName($order->provider_category . '_' . $name)->first()->count;
    }
}
