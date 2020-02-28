<?php

namespace App\Http\Controllers\ApiClient\Product;

use App\Http\Controllers\Controller;
use App\Contracts\Client\Product\FilterInterface;
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
     * @apiSampleRequest client/filter?kitchen=italy&rating=3,5&price_rating=1,5&tag=not_noisy
     */

    public function getByFilters(Request $request)
    {
        return $this->filter->getByFilters($request);
    }


    /**
     * @api {get} client/filter/ratings-prices Get ratings prices all
     * @apiName  Get ratings prices all
     * @apiVersion 1.1.1
     * @apiGroup Client Filters
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest client/filter/ratings-prices
     */

    public function getRatingsPrices()
    {
        return $this->filter->getRatingsPrices();
    }

}
