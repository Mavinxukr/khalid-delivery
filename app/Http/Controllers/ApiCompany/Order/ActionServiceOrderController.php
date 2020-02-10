<?php

namespace App\Http\Controllers\ApiCompany\Order;

use App\Contracts\Company\Order\ActionServiceOrderInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActionServiceOrderController extends Controller
{
    private $order;

    public function __construct(ActionServiceOrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * @api {post} company/take-service-order Take service order #Screen 21
     * @apiName  Take service order
     * @apiVersion 1.1.1
     * @apiGroup Company Action  Order
     * @apiParam {Number} order_id Order Id
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/take-service-order
     */

    public function takeServiceOrder(Request $request)
    {
        return $this->order->take($request);
    }


    /**
     * @api {patch} company/cancel-service-order/{id} Cancel service order #Screen 21, 22
     * @apiName  Cancel service order
     * @apiVersion 1.1.1
     * @apiGroup Company Action  Order
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/cancel-service-order/{id}
     */

    public function cancelServiceOrder(Request $request, int  $id)
    {
        return $this->order->cancel($request, $id);
    }

    /**
     * @api {post}  company/done-service-order Done service order
     * @apiName  Done service order
     * @apiVersion 1.1.1
     * @apiGroup Company Action  Order
     * @apiParam {Number} order_id Order Id
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/done-service-order
     */

    public function doneFoodOrder(Request $request)
    {
        return $this->order->doneFoodOrder($request);
    }
}
