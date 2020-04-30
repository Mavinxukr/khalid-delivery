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
     * @api {post} client/answers  Store Answers Доделки
     * @apiName  Store Answers Доделки
     * @apiVersion 1.1.1
     * @apiGroup Client Answers
     * @apiParam {String} answers Answers
     * example: 'q=1,a=1' objects delimiter by ;
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/answers
     */
    public function store(Request $request)
    {
        return $this->preOrder->store($request);
    }
}
