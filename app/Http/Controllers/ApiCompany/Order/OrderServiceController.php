<?php

namespace App\Http\Controllers\ApiCompany\Order;

use App\Contracts\Company\Order\ServiceOrderInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderServiceController extends Controller
{
     private  $order;

    public function __construct(ServiceOrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * @api {get} company/get-service-order Get service order #Screen №21
     * @apiName  Get service order
     * @apiVersion 1.1.1
     * @apiGroup Company Service Order
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/get-service-order
     */

    public function getServiceOrder(Request $request)
    {
        return $this->order->getAllOrder($request);
    }


    /**
     * @api {get} company/get-service-order-no-geo Get service order #Screen №21
     * @apiName  Get service order
     * @apiVersion 1.1.1
     * @apiGroup Company Service Order
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/get-service-order-no-geo
     */


    public function getAllOrderNoGeo(Request $request)
    {
        return $this->order->getAllOrderNoGeo($request);
    }

    /**
     * @api {get} company/get-service-order/{id} Get service order by id #Screen №22
     * @apiName  Get service order by id
     * @apiVersion 1.1.1
     * @apiGroup Company Service Order
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/get-service-order/{id}
     */

    public function getServiceOrderById(Request $request, int  $id)
    {
        return $this->order->getOneOrder($request, $id);
    }

    /**
     * @api {get} company/get-service-order-by-filters?price_from=10&price_to=100 Get service order by filters #Screen №23
     * @apiName  Get service order by filters
     * @apiVersion 1.1.1
     * @apiGroup Company Service Order
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/get-service-order-by-filters?price_from=10&price_to=100
     */

    public function getServiceOrderByFilters(Request $request)
    {
        return $this->order->getAllOrderByFilters($request);
    }
}
