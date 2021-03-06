<?php

namespace App\Http\Controllers\ApiClient\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Contracts\Client\Order\OrderServiceInterface;
use App\Http\Requests\TransactionRequest;
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
     * @apiParam {String} payment_type Payment Type (card, cash)
     * @apiParam {string} product_id Service ID from api - Show services
     * @apiParam {string} answers Answers
     * example: 'q=1,a=1' objects delimiter by;
     * @apiParam {Number} place_id Place ID from api - Get users' places
     * @apiParam {String} date_delivery Date (format 2019-11-29)
     * @apiParam {String} date_delivery_from Time (format 14:00:00)
     * @apiParam {String} date_delivery_to Time (format 16:00:00)
     * @apiParam {String} type_cleaning Type cleaning  <br> 1 - house, 2 - office, 3 - flat
     * @apiParam {String} callback_time Callback time <br> 10:00
     * @apiParam {String} b2b_1 B2B 1
     * @apiParam {String} b2b_2 B2B 2
     * @apiParam {String} b2b_3 B2B 3
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

    public function confirmOrder(TransactionRequest $request)
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

    /**
     * @api {get} client/order-requests/{id}  Show order requests UPDATE 25.08.20
     * @apiName  Show order requests
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Service
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/order-requests/{id}
     */
    public function showRequests(int $id)
    {
        return $this->order->showRequests($id);
    }

    /**
     * @api {post} client/order-request-accept/{request_id}  Accept order requests UPDATE 25.08.20
     * @apiName  Accept order requests
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Service
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/order-request-accept/{request_id}
     */
    public function acceptRequest(int $id)
    {
        return $this->order->acceptRequest($id);
    }

    /**
     * @api {post} client/order-request-decline/{request_id}  Decline order requests UPDATE 25.08.20
     * @apiName  Decline order requests
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Service
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/order-request-decline/{request_id}
     */
    public function declineRequests(int $id)
    {
        return $this->order->declineRequest($id);
    }



    /**
     * @api {get} client/order-requests  Show all order requests UPDATE 25.08.20
     * @apiName  Show all order requests
     * @apiVersion 1.1.1
     * @apiGroup Client Order - Service
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/order-requests
     */

    public function showAllRequests(Request $request)
    {
        return $this->order->showAllRequests($request);
    }
}
