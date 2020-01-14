<?php

namespace App\Http\Controllers\ApiClient\Product;

use App\Http\Controllers\Controller;
use App\Interfaces\Client\Product\FilterInterface;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    private  $filter;

    public function __construct(FilterInterface $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @api {get} client/filter/kitchens Get kitchens #Screen №17,18,45
     * @apiName  Get kitchens
     * @apiVersion 1.1.1
     * @apiGroup Client Filters
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest client/filter/kitchens
     */

    public function getKitchen()
    {
        return $this->filter->getKitchen();
    }

    /**
     * @api {get} client/filter Get by filters #Screen №17,18 ,45
     * @apiName   Get by filters
     * @apiVersion 1.1.1
     * @apiGroup Client Filters
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest client/filter?kitchen=italy&rating=3&price_rating=5&tag=not_noisy
     */

    public function getByFilters(Request $request)
    {
        return $this->filter->getByFilters($request);
    }
}
