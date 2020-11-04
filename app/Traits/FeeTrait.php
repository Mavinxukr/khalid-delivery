<?php

namespace App\Traits;

use App\Models\Fee\Fee;
use App\Models\Order\Order;
use App\Models\Reward\Reward;

trait FeeTrait
{
    public function getFee($type, $name)
    {
        return Fee::whereName($type . '_' . $name)->first()->count;
    }

    public static function getFeeStatic($type, $name)
    {
        return Fee::whereName($type . '_' . $name)->first()->count;
    }

    public function rewardAction(Order $order,  float $bonus)
    {
        $rewardUser = Reward::where([
            'recipient_email'  => $order->user->email,
            'used'          => true
        ])->get();
        foreach ($rewardUser as $user){
            $user->sender->bonus += $bonus;
            $user->sender->save();
        }
    }
}
