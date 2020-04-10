<?php

namespace App\Http\Controllers\ApiClient\FAQ;

use App\Contracts\Client\FAQ\FaqInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    private $query;

    public function __construct(FaqInterface $query)
    {
        $this->query       = $query;
    }

    /**
     * @api {get} client/faq  Show FAQ - Доделки
     * @apiName  Show FAQ
     * @apiVersion 1.1.1
     * @apiGroup Client FAQ
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/faq
     */
    public function index(Request $request)
    {
        return $this->query->index();
    }
}
