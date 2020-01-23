<?php

namespace App\Http\Controllers\ApiCompany\Order;

use App\Contracts\Company\Order\FoodOrderInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderFoodController extends Controller
{
    private $order;

    public function __construct(FoodOrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * @api {get} company/get-food-order Get food order #Screen №11
     * @apiName  Get food order
     * @apiVersion 1.1.1
     * @apiParam {String} status Status (Available statuses: confirm - this is for In progress orders, </br>
     *                                                       done - this is for Archives  orders )
     * @apiGroup Company Food Order
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/get-food-order
     */

    public function getFoodOrder(Request $request)
    {
        return $this->order->getAllOrder($request);
    }

    /**
     * @api {get} company/get-food-order/{id} Get food order by id #Screen №18
     * @apiName  Get food order by id
     * @apiVersion 1.1.1
     * @apiGroup Company Food Order
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/get-food-order/{id}
     */

    public function getOrderById(Request $request, int $id)
    {
        return $this->order->getOrderById($request, $id);
    }

    /**
     * @api {get} company/get-food-order/{order_id}/{product_id} Get food product in order by id #Screen №20
     * @apiName  Get food product in order by id
     * @apiVersion 1.1.1
     * @apiGroup Company Food Order
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/get-food-order/{order_id}/{product_id}
     */

    public function getProductInOrderById(Request $request, int $order_id, int $product_id)
    {
        return $this->order->getProductInOrderById($request, $order_id, $product_id);
    }
}
