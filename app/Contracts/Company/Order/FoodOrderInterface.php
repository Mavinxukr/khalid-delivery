<?php


namespace App\Contracts\Company\Order;


use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface FoodOrderInterface extends FormatInterface
{
    public function getAllOrder(Request $request);

    public function getOrderById(Request $request, int  $id);

    public function getProductInOrderById(Request $request,int $order_id, int $product_id);

    public function takeFoodOrder(Request $request);

    public function doneFoodOrder(Request $request);

    public function cancelFoodOrder(Request $request , int $id);

    public function getFoodOrderWithOutStatus(Request $request);

    public function cancelFoodOrderItems(Request $request, int $id);
}
