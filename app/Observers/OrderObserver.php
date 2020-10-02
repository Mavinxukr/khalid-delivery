<?php

namespace App\Observers;

use App\Models\Fee\Fee;
use App\Models\Order\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    public function updated(Order $order)
    {
     /*   Log::info($order->debt .'----'. $order->service_received );
        return;
        if($order->debt != $order->service_received){
            $order->debt = $order->company_received;
            $order->save();
        }*/

        if(!is_null($order->preOrder) &&
            !is_null($order->status) &&
            $order->preOrder->status != $order->status){
                $order->preOrder()->update(['status' => $order->status]);
        }

        //sendpush обновлен заказ
    }

    private function getFee($order, $name){
        return Fee::whereName($order->provider_category . '_' . $name)->first()->count;
    }
}
