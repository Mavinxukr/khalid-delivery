<?php

namespace App\Http\Controllers\ApiClient\Place;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceRequest;
use App\Interfaces\Client\Place\PlaceInterface;
use Illuminate\Http\Request;

class PlaceServiceController extends Controller
{
    private $place;

    public function __construct(PlaceInterface $place)
    {
        $this->place = $place;
    }


    /**
     * @api {get} client/places  Get users' places #Screen №2, 40
     * @apiName  Store product service
     * @apiVersion 1.1.1
     * @apiGroup Client Place
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/places
     */

    public function index(Request $request)
    {
        return $this->place->getAll($request->user());
    }

    /**
     * @api {post} client/places Store place #Screen №4, 46
     * @apiName  Store place
     * @apiVersion 1.1.1
     * @apiGroup Client Place
     * @apiParam {String} name Name
     * @apiParam {String} address Address (Воскресенская улица 38)
     * @apiParam {String} city City (Днепр)
     * @apiParam {String} postal_code Postal Code (49020)
     * @apiParam {String} country Country (UA)
     * @apiParam {String} latitude Latitude (48.4649)
     * @apiParam {String} longitude Longitude (35.0394)
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/places
     */

    public function store(PlaceRequest $request)
    {
        return $this->place->store($request);
    }
}
