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

    public function doneServiceOrder(Request $request)
    {
        return $this->order->doneServiceOrder($request);
    }

    /**
     * @api {post} company/send-my-location/{id} Send my location for Order Update 25.08.20
     * @apiName  Send my location for Order
     * @apiVersion 1.1.1
     * @apiGroup Company Action  Order
     * @apiParam {String} lat Lat
     * @apiParam {String} lng Lng
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/send-my-location/{id}
     */

    public function sendMyLocation(Request $request, int  $id)
    {
        return $this->order->sendMyLocation($request, $id);
    }

    /**
     * @api {post} company/extend-service-order/{id} Extend service Order Update 25.08.20
     * @apiName  Extend service Order
     * @apiVersion 1.1.1
     * @apiGroup Company Action  Order
     * @apiParam {String} extend_to Extend To (18:00:00)
     * @apiParam {Text} reason Reason For Extend
     * @apiParam {Array} files Array of Files
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/extend-service-order/{id}
     */

    public function extendServiceOrder(Request $request, int  $id)
    {
        return $this->order->extendServiceOrder($request, $id);
    }
}
