<?php


namespace App\Repositories\Client;


use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Place\PlaceInterface;
use App\Models\PlaceService\Place;

class PlaceRepository implements PlaceInterface
{

    public function getAll($user)
    {
        $places = $user->place()
                        ->orderBy('name', 'ASC')
                        ->get()
                        ->map(function ($item){
                            return $this->format($item);
                        });
        return TransJsonResponse::toJson(true,$places,'All users\' places',200);
    }

    public function store($request)
    {
        $place =  Place::create($request->all()+ [
            'user_id' => $request->user()->id
            ]);
        $data =  $this->format($place);

        return TransJsonResponse::toJson(true,$data,'Place was added',201);
    }

    public function format($data)
    {
        return [
            'id'            => $data->id,
            'name'          => $data->name,
            'address'       => $data->address,
            'postal_code'   => $data->postal_code,
            'country'       => $data->country,
            'latitude'      => $data->latitude,
            'longitude'     => $data->longitude
        ];
    }


}
