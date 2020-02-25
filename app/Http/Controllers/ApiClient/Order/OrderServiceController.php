<?php

namespace App\Http\Controllers\ApiClient\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Contracts\Client\Order\OrderServiceInterface;
use Illuminate\Http\Request;

class OrderServiceController extends Controller
{
    private $order;

    public function __construct(OrderServiceInterface $order)
    {
        $this->order  = $order;
    }

    /**
     * @api {post} client/orders  Store service  order #Screen №2, 3, 4 , 41, 42 ,42
     * @apiName  Store  order
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Service
     * @apiParam {String} name Name
     * @apiParam {string} product_id Service ID from api - Show services
     * @apiParam {Number} place_id Place ID from api - Get users' places
     * @apiParam {String} date_delivery Date (format 2019-11-29)
     * @apiParam {String} date_delivery_from Time (format 14:00:00)
     * @apiParam {String} date_delivery_to Time (format 16:00:00)
     * @apiParam {String} type_cleaning Type cleaning  <br> 1 - house, 2 - office, 3 - flat
     * @apiParam {String} count_clean Count cleaning
     * @apiParam {Number} interval Interval
     * @apiParam {Number} quantity Quantity hours
     * @apiParam {String} callback_time Callback time <br> 10:00
     * @apiParam {Text} comment Comment
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/orders
     */

    public function store(OrderRequest $request)
    {
        return $this->order->store($request);
    }
    /**
     * @api {get} client/orders/{id}  Show order #Screen №5, 7
     * @apiName  Show order
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Service
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/orders/{id}
     */
    public function show(int $id)
    {
        return $this->order->show($id);

    }

    /**
     * @api {post} client/orders/confirm  Confirm order  #Screen №7
     * @apiName  Confirm order
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Service
     * @apiParam {Number} id Order id
     * @apiParam {String} transaction_id Transaction id
     * @apiParam {String} status Status code from payment
     * @apiParam {String} message Message  from payment
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/orders/confirm
     */

    public function confirmOrder(Request $request)
    {
        return $this->order->confirmOrder($request);
    }

    /**
     * @api {post} client/orders/cancel  Cancel order  #Screen №8
     * @apiName  Client Order
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Service
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
     * @api {post} client/orders/restore  Restore order  #Screen №20
     * @apiName  Restore order
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Service
     * @apiParam {Number} id Order id
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/orders/restore
     */

    public function restoreOrder(Request $request)
    {
        return $this->order ->restoreOrder($request->id);
    }
}
