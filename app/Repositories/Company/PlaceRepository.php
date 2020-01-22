<?php


namespace App\Repositories\Company;


use App\Contracts\Company\Place\PlaceInterface;
use App\Contracts\FormatInterface;
use App\Models\PlaceService\Place;
use Illuminate\Http\Request;

class PlaceRepository implements PlaceInterface, FormatInterface
{
    public function store(Request $request)
    {
       Place::create($request->all()+
       [
           'user_id'        => $request->user()->id,
           'provider_type'  => 'company',
           'provider_id'    => $request->user()->provider->id
       ]
       );
    }

    public function format($data)
    {
        // TODO: Implement format() method.
    }
}
