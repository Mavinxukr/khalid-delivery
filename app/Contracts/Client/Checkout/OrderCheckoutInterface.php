<?php


namespace App\Contracts\Client\Checkout;


use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface OrderCheckoutInterface extends FormatInterface
{
    public function checkout(Request $request);
}
