<?php

namespace App\Observers;

use App\Models\Fee\Fee;
use App\Models\Order\Order;
use App\Models\Reward\Reward;
use App\Traits\FeeTrait;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    use FeeTrait;

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

        //send push обновлен заказ
    }


    public function deleting(Order $order)
    {
        \DB::table('order_details')->where('order_id',$order->id)->delete();
    }

    private function getFee($order, $name){
        return Fee::whereName($order->provider_category . '_' . $name)->first()->count;
    }
}
