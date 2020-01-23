<?php


namespace App\Contracts\Company\Order;


use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface FoodOrderInterface extends FormatInterface
{
    public function getAllOrder(Request $request);

    public function getOrderById(Request $request, int  $id);

    public function getProductInOrderById(Request $request,int $order_id, int $product_id);
}
