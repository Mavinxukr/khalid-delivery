<?php

namespace App\Helpers;

use App\Models\Provider\Provider;
use App\Traits\FeeTrait;

class ServiceOrderHelper
{
    use FeeTrait;

    public function calculateCost($cost)
    {
        $orderCost =  $cost + $this->getFee('service', 'charge');
        $orderCost =  $orderCost + ($orderCost / 100 * $this->getFee('service', 'vat'));
        $serviceReceivedCost    = ($cost / 100 *
                $this->getFee('service', 'received')) / 100 *
            $this->getFee('service', 'vat');
        $companyReceivedCost        = $orderCost - $serviceReceivedCost;

        return [
            'cost'              => round($orderCost, 2),
            'service_received'  => round($serviceReceivedCost, 2),
            'company_received'  => round($companyReceivedCost, 2),
        ];
    }
}
