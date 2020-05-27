<?php

namespace App\Http\Controllers\ApiClient\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderFoodRequest;
use App\Http\Requests\OrderRequest;
use App\Contracts\Client\Order\OrderFoodInterface;
use Illuminate\Http\Request;

class OrderFoodController extends Controller
{
    private $order;

    public function __construct(OrderFoodInterface $order)
    {
        $this->order = $order;
    }


    /**
     * @api {post} client/food-orders  Store food  order #Screen №26, 27, 28,29
     * @apiName  Store food  order
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Food
     * @apiParam {String} name Name
     * @apiParam {String} payment_type Payment Type (card, cash)
     * @apiParam {Number} place_id Place ID from api - Get users' places
     * @apiParam {String} date_delivery Date (format 2019-11-29)
     * @apiParam {String} date_delivery_from Time (format 14:00:00)
     * @apiParam {Number} callback_time Callback time <br> 10, 15, 30, 60 - min
     * @apiParam {String} b2b_1 B2B 1
     * @apiParam {String} b2b_2 B2B 2
     * @apiParam {String} b2b_3 B2B 3
     * @apiParam {Text} comment Comment
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/food-orders
     */

    public function store(OrderFoodRequest $request)
    {
        return $this->order->store($request);
    }
    /**
     * @api {get} client/food-orders/{id}  Show food order  #Screen №5, 7
     * @apiName  Show food order
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Food
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/food-orders/{id}
     */
    public function show(int $id)
    {
        return $this->order->show($id);

    }

    /**
     * @api {post} client/food-orders/confirm  Confirm food order  #Screen №7
     * @apiName  Confirm food order
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Food
     * @apiParam {Number} id Order id
     * @apiParam {String} transaction_id Transaction id
     * @apiParam {String} status Status code from payment
     * @apiParam {String} message Message  from payment
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest   client/food-orders/confirm
     */

    public function confirmOrder(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|max:255',
        ]);
        return $this->order->confirmOrder($request);
    }

    /**
     * @api {post} client/food-orders/confirm  Cancel food order  #Screen №8
     * @apiName  Client Order
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Food
     * @apiParam {Number} id Order id
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/orders/cancel
     */

    public function cancelOrder(Request $request)
    {
        return $this->order->cancelOrder($request);
    }

    /**
     * @api {post} client/food-orders/restore  Restore food order  #Screen №20
     * @apiName  Restore food order
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Food
     * @apiParam {Number} id Order id
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/food-orders/restore
     */

    public function restoreOrder(Request $request)
    {
        return $this->order->restoreOrder($request->id);
    }

}
