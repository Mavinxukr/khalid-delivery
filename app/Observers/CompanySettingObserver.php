<?php

namespace App\Observers;

use App\Models\Product\Product;
use App\Models\Provider\Kitchen;
use App\Models\Provider\SettingProvider;

class CompanySettingObserver
{
    public function created(SettingProvider $settingProvider)
    {
        $kitchens = explode(',',$settingProvider->kitchen);

        foreach ($kitchens as $kitchen){
            Kitchen::updateOrCreate([
                'name' => $kitchen
            ]);
        }
    }
}
