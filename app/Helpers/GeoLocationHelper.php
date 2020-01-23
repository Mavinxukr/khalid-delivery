<?php


namespace App\Helpers;

use App\Models\Order\Order;
use App\Models\PlaceService\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeoLocationHelper
{
    private static function getOrderByGeoLocation(float $latitude, float $longitude,
                                                 string $type, int $radius = 25) :array
    {
        $lat = $latitude * 0.0174532925;
        $lng = $longitude * 0.0174532925;
        $radius = $radius / 1.66;

        $entity = Place::select('id',DB::raw("ACOS(SIN({$lat}) * SIN(`latitude`*0.0174532925) +
                                                        COS({$lat}) * COS(`latitude`*0.0174532925) *
                                                        COS(`longitude`*0.0174532925 - {$lng})
                                                        ) * 3956 AS distance"))
                                ->havingRaw('distance < ?', [(int)$radius])
                                ->whereHas('order')
                                ->get()
                                ->pluck('id')
                                ->toArray();

        return  Order::whereIn('place_id',$entity)
                         ->where('provider_category','=',$type)
                         ->get()
                         ->pluck('id')
                         ->toArray();
    }

    public static  function getOrderIds(Request $request, string $type)
    {
        $geoCompany = $request->user()
            ->company
            ->geoLocation
            ->whereProviderId($request->user()->company->id)
            ->first(['latitude','longitude']);
        return self::getOrderByGeoLocation($geoCompany->latitude, $geoCompany->longitude,$type);
    }

}
