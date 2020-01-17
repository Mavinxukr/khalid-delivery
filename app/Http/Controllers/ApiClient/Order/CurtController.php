<?php

namespace App\Http\Controllers\ApiClient\Order;

use App\Http\Controllers\Controller;
use App\Interfaces\Client\Order\CartInterface;
use Illuminate\Http\Request;

class CurtController extends Controller
{
    private $cart;

    public function __construct(CartInterface $cart)
    {
        $this->cart = $cart;
    }



    /**
     * @api {get} client/cart  Show products in cart #Screen №25
     * @apiName  Show products in cart
     * @apiVersion 1.1.1
     * @apiGroup Client cart
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/cart
     */

    public function index(Request $request)
    {
        return $this->cart->index($request);
    }


    /**
     * @api {post} client/cart  Add to cart #Screen №13,16,39
     * @apiName  Add to cart
     * @apiVersion 1.1.1
     * @apiGroup Client cart
     * @apiParam {string} product_id Service ID from api - Show services
     * @apiParam {Number} quantity Quantity
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/cart
     */

    public function store(Request $request)
    {
        return $this->cart->store($request);
    }

    /**
     * @api {patch} client/cart/{id}  Update  cart #Screen №25
     * @apiName  Update  cart
     * @apiVersion 1.1.1
     * @apiGroup Client cart
     * @apiParam {Number} quantity Quantity
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/cart/cart/{id}
     */

    public function update(Request $request, $id)
    {
        return $this->cart->update($request, $id);
    }

    /**
     * @api {delete} client/cart/{product_id}  Delete from  cart #Screen №25
     * @apiName  Delete from  cart
     * @apiVersion 1.1.1
     * @apiGroup Client cart
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/cart/{product_id}
     */

    public function destroy(int $id)
    {
        return $this->cart->delete($id);
    }


}
