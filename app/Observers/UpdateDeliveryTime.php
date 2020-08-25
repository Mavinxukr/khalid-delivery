<?php

namespace App\Observers;

use App\Models\Provider\Provider;

class UpdateDeliveryTime
{
    public function updated(Provider $provider)
    {
        \Log::info($provider->orders()->first());
    }
}
