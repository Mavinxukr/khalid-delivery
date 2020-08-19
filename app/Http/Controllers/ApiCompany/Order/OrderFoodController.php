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
     *                                                       new - which  need to confirm             </br>
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

    /**
     * @api {post}  company/take-food-order Take food order #Screen №20
     * @apiName  Take food order
     * @apiVersion 1.1.1
     * @apiGroup Company Food Order
     * @apiParam {Number} order_id Order Id
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/take-food-order
     */

    public function takeFoodOrder(Request $request)
    {
        return $this->order->takeFoodOrder($request);
    }


    /**
     * @api {post}  company/in-progress-food-order In Progress food order UPDATE 17.08.20
     * @apiName  In Progress food order
     * @apiVersion 1.1.1
     * @apiGroup Company Food Order
     * @apiParam {Number} order_id Order Id
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/in-progress-food-order
     */

    public function inProgressFoodOrder(Request $request)
    {
        return $this->order->inProgressFoodOrder($request);
    }

    /**
     * @api {patch} company/cancel-food-order/{id} Cancel food order
     * @apiName  Cancel food order
     * @apiVersion 1.1.1
     * @apiGroup Company Food  Order
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/cancel-food-order/{id}
     */


    public function cancelFoodOrder(Request $request,$id)
    {
        return $this->order->cancelFoodOrder($request,$id);
    }

    /**
     * @api {post}  company/done-food-order Done food order
     * @apiName  Done food order
     * @apiVersion 1.1.1
     * @apiGroup Company Food Order
     * @apiParam {Number} order_id Order Id
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/done-food-order
     */

    public function doneFoodOrder(Request $request)
    {
        return $this->order->doneFoodOrder($request);
    }

    /**
     * @api {get}  company/get-food-order-no-status Get food order no status
     * @apiName  Get food order no status
     * @apiVersion 1.1.1
     * @apiGroup Company Food Order
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/get-food-order-no-status
     */

    public function getOrderWithOutStatus(Request $request)
    {
        return $this->order->getFoodOrderWithOutStatus($request);
    }

    /**
     * @api {post}  company/cancel-food-order-items/{id} Cancel food order items UPDATE 17.08.2020
     * @apiName  Cancel food order items
     * @apiVersion 1.1.1
     * @apiGroup Company Food Order
     * @apiParam {Text} product_ids Product Ids (delimiter by ,)
     * @apiParam {Text} description Description
     * @apiParam {File} image Image (not required)
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/cancel-food-order-items/{id}
     */

    public function cancelFoodOrderItems(Request $request, $id)
    {
        return $this->order->cancelFoodOrderItems($request, $id);
    }
}
