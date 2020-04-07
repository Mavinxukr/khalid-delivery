<?php

namespace App\Http\Controllers\ApiClient\Query;

use App\Contracts\Client\Query\QueryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    private $query;

    public function __construct(QueryInterface $query)
    {
        $this->query       = $query;
    }

    /**
     * @api {get} client/query  Show query - Доделки
     * @apiName  Show query
     * @apiVersion 1.1.1
     * @apiGroup Client query
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/query
     */
    public function index(Request $request)
    {
        return $this->query->index();
    }

}
