<?php

namespace App\Http\Controllers\ApiCompany\Place;

use App\Contracts\Company\Place\PlaceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceRequest;
use Illuminate\Http\Request;

class CompanyPlace extends Controller
{
    private  $place;

    public function __construct(PlaceInterface $place)
    {
         $this->place = $place;
    }

    /**
     * @api {post} company/geo Store geolocation company #Screen №4,5,6
     * @apiName  Store place
     * @apiVersion 1.1.1
     * @apiGroup Company Place
     * @apiParam {String} address Address (Воскресенская улица 38)
     * @apiParam {String} city City (Днепр)
     * @apiParam {String} postal_code Postal Code (49020)
     * @apiParam {String} country Country (UA)
     * @apiParam {String} latitude Latitude (48.4649)
     * @apiParam {String} longitude Longitude (35.0394)
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/geo
     */

    public function store(PlaceRequest $request)
    {
        return $this->place->store($request);
    }
}
