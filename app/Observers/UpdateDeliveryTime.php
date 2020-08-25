<?php

namespace App\Observers;

use App\Models\Provider\Provider;
use App\Notifications\UserChangeDataDelivery;
use Carbon\Carbon;

class UpdateDeliveryTime
{
    public function updated(Provider $provider)
    {

        if (isset($provider->getChanges()['provider_status'])){
            foreach ($provider->orders()->get() as $order){
                if ($provider->providerStatus->time > 0){
                    if ($order->date_delivery_to == 'empty'){
                        $time_str =  Carbon::parse($order->date_delivery_from);
                        $time = Carbon::createFromTimeString($time_str);

                        $order->date_delivery_from =
                            $time->addMinutes($provider->providerStatus->time)->format('H:i:s');
                    }else{
                        $time_str =  Carbon::parse($order->date_delivery_to);
                        $time = Carbon::createFromTimeString($time_str);
                        $order->date_delivery_to = $time->addMinutes($provider->providerStatus->time);
                    }
                    $order->save();
                }

                $time = $order->date_delivery_to == 'empty' ?$order->date_delivery_from: $order->date_delivery_to;
                $order->user->notify(new UserChangeDataDelivery($time));

            }
        }

    }
}
