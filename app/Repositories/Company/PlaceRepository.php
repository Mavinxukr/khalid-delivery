<?php


namespace App\Repositories\Company;


use App\Contracts\Company\Place\PlaceInterface;
use App\Contracts\FormatInterface;
use App\Helpers\TransJsonResponse;
use App\Models\PlaceService\Place;
use Illuminate\Http\Request;

class PlaceRepository implements PlaceInterface
{
    public function store(Request $request)
    {
        $condition = !is_null($request->user()->company) &&
                     $request->user()->company->categories->type === 'service';
        if ($condition) {
            Place::updateOrcreate(
                [
                    'provider_id' => $request->user()->company->id
                ],
                $request->all() +
                [
                    'user_id' => $request->user()->id,
                    'provider_type' => 'company',
                    'provider_id' => $request->user()->company->id
                ]);
            $place = Place::whereProviderId($request->user()->company->id)
                            ->first();
            return TransJsonResponse::toJson(true,$this->format($place),
                                    'Geolocation was created',200);
        }else{
            return TransJsonResponse::toJson(false,null,
                'You do not consist any company or you provider type not equal - service',400);
        }
    }

    public function getCompanyGeo(Request $request)
    {
        $place =  $request->user()->company->geoLocation;
        if (is_null($place)){
            return TransJsonResponse::toJson(false, null,
                        'You have not any geoplace',200);
        }

        return TransJsonResponse::toJson(true,$this->format($place),
                                        'Geolocation company',200);
    }

    public function format($data)
    {
        return [
            'id'        => $data->id,
            'city'      => $data->city,
            'address'   => $data->address,
            'country'   => $data->country,
            'latitude'  => $data->latitude,
            'longitude' => $data->longitude,
            'company'   => $data->company->name
        ];
    }
}
