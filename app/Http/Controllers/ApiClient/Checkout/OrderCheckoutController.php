<?php

namespace App\Http\Controllers\ApiClient\Checkout;

use App\Contracts\Client\Checkout\OrderCheckoutInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderCheckoutController extends Controller
{
    private $checkout;

    public function __construct(OrderCheckoutInterface $checkout)
    {
      $this->checkout = $checkout;
    }

    /**
     * @api {post} client/checkout  Checkout  order service
     * @apiName  Checkout  order service
     * @apiVersion 1.1.1
     * @apiGroup Client Checkout
     * @apiParam {String} card_token Card token from SDK
     * @apiParam {String} order_id Order id
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/checkout
     */

    public function checkout(Request $request)
    {
        return $this->checkout->checkout($request);
    }
}
