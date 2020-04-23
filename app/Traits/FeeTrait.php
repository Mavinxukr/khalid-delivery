<?php

namespace App\Traits;

use App\Models\Fee\Fee;

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
}
