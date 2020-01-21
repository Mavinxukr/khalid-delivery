<?php

namespace App\Http\Controllers\ApiCompany\Category;

use App\Contracts\Company\Service\CompanyServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyServiceRequest;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private  $service;

    public function __construct(CompanyServiceInterface $service)
    {
         $this->service = $service;
    }

    /**
     * @api {post} company/create-service Create company exclusive service #Screen 3
     * @apiName  Create company exclusive service
     * @apiVersion 1.1.1
     * @apiGroup Company  Service
     * @apiParam {String} title Title
     * @apiParam {Text} description Description
     * @apiParam {Number} price Price
     * @apiParam {Number} price_for_hour Price for hour
     * @apiParam {File} image Image
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/create-service
     */

    public function create(CompanyServiceRequest $request)
    {
        return $this->service->create($request);
    }
}
