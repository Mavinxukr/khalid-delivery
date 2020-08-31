<?php

namespace App\Helpers;

use App\Models\Provider\Provider;
use App\Traits\FeeTrait;

class FoodOrderHelper
{
    use FeeTrait;

    public function calculateCost($provider_id, $cost)
    {
        $provider = Provider::find($provider_id);

        $markupCast = ($cost / 100 * $this->getFee('food', 'markup'));
        $cents = round(($markupCast - floor($markupCast)) * 100);
        $centsFloor = $cents % 10;
        $cents = $cents - $centsFloor;
        if($centsFloor < 5){
            $cents = ($cents + 5) / 100;
        }else{
            $cents = ($cents + 10) / 100;
        }

        $vat = $cost/ 100 * $this->getFee('food', 'vat');

        if($provider->enablec_market_charge){
            $charge = $provider->count_market_charge;
        }else{
            $charge = ($provider->charge == 1) ? $this->getFee('food', 'charge') : 0;
        }



        $serviceReceivedCost = (($cost + $vat) / 100 * $this->getFee('food', 'received'));
        $companyReceivedCost = (floor($markupCast) + $cents) + $vat + $charge
         + $cost / 100 * (100 - $this->getFee('food', 'received'));

        $orderCost = $serviceReceivedCost + $companyReceivedCost;
        $orderCost = $orderCost + ($orderCost * $provider->count) / 100;

        return [
            'cost'              => round($orderCost, 2),
            'service_received'  => round($serviceReceivedCost, 2),
            'company_received'  => round($companyReceivedCost, 2),
        ];
    }
}
