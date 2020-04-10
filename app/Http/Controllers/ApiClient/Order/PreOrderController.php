<?php

namespace App\Http\Controllers\ApiClient\Order;

use App\Contracts\Client\Order\PreOrderInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreOrderController extends Controller
{
    private $preOrder;

    public function __construct(PreOrderInterface $preOrder)
    {
        $this->preOrder = $preOrder;
    }

    /**
     * @api {post} client/pre-order  Create Pre Order Доделки
     * @apiName  Create Pre Order Доделки
     * @apiVersion 1.1.1
     * @apiGroup Client PreOrder
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/pre-order
     */
    public function store(Request $request)
    {
        return $this->preOrder->store($request);
    }

    /**
     * @api {post} client/pre-order/{id}  Store Answers in Pre Order Доделки
     * @apiName  Store Answers in Pre Order Доделки
     * @apiVersion 1.1.1
     * @apiGroup Client PreOrder
     * @apiParam {String} components Components
     * example: 'product_id=2,answer=true/false/{empty},count=3/{empty}' objects delimiter by ;
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/pre-order/{id}
     */
    public function update(Request $request, int $id)
    {
        return $this->preOrder->update($request, $id);
    }
}
