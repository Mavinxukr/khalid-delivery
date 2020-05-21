<?php


namespace App\Repositories\Client;


use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Product\FilterInterface;
use App\Contracts\FormatInterface;
use App\Models\Category\Category;
use App\Models\Provider\Kitchen;
use App\Models\Provider\Provider;
use DB;
use Illuminate\Support\Facades\Request;

class FilterRepository implements FilterInterface
{

    public function getKitchen()
    {
      $kitchens =  Kitchen::orderBy('name','ASC')
                    ->get('name');
      return TransJsonResponse::toJson(true,$kitchens,'All kitchens',200);

    }

    public function format($data)
    {
        return  [
            'id'                => $data->id,
            'title'             => $data->title ?? $data->name,
            'image'             => ImageLinker::linker($data->image),
            'rating'            => $data->providerSetting->rating ?? 0,
            'price_rating'      => $data->providerSetting->price_rating ?? 0,
            'time_delivery'     => $data->providerSetting->time_delivery_mean ?? null,
            'working_hours'     => $data->providerSetting->schedule ?? null,
            'min_order_value'   => $data->providerSetting->min_order ?? null,
            'delivery_fee'      => $data->providerSetting->delivery_fee ?? null,
            'kitchen'           => $data->providerSetting->kitchen ?? null,
            'product_count'     => $data->product()->count(),
        ];
    }

    public function getByFilters($data)
    {
        $category = Category::whereType('food')->first();
        $companies = Provider::query()
                    ->where('category_id', $category->id);
        $result  = null;

        if (!count($data->all())){
            $result = $companies->get()
                ->map(function ($item){
                    return $this->format($item);
                });
        }else{
            $companies->join('setting_providers','providers.id','=','setting_providers.provider_id');
            if ($data->has('kitchen')){
                $companies->where('setting_providers.kitchen','LIKE','%' . $data->get('kitchen') . '%');
            }
            if ($data->has('rating')){

                $arrRating = explode(',',$data->rating);

                $from = $arrRating[0];
                $to = isset($arrRating[1]) ? $arrRating[1] : null;


                $companies->where('setting_providers.rating','>=',$from);

                if (!is_null($to)){
                    $companies->where('setting_providers.rating','<=',$to);
                }
            }
            if ($data->has('price_rating')){
                $arrRating = explode(',',$data->price_rating);

                $from = $arrRating[0];
                $to = isset($arrRating[1]) ? $arrRating[1] : null;
                $companies->where('setting_providers.price_rating','>=',$from);
                if (!is_null($to)){
                    $companies->where('setting_providers.price_rating','<=',$to);
                }
            }
            if ($data->has('tag')){
                $companies->where('setting_providers.tags','LIKE','%' .  $data->get('tag') . '%');
            }

            $result = $companies->select('providers.*')
                ->get()
                ->map(function ($item){
                    return $this->format($item);
                });
        }

        return TransJsonResponse::toJson(true, $result,'Company get by filters',200);
    }

    public function getRatingsPrices()
    {
        $category = Category::whereType('food')->first();
        $arrayRating = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ];
        $arrayRatingPrice = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ];
        $companies = Provider::where('category_id',$category->id)->get();
        foreach ($companies as $company){
            $arrayRating[$company->providerSetting->rating] += 1;
        }
        foreach ($companies as $company){
            $arrayRatingPrice[$company->providerSetting->price_rating] += 1;
        }
        $result = collect( ['rating' => $arrayRating, 'rating_price' => $arrayRatingPrice]);
        return TransJsonResponse::toJson(true, $result,'Get all  rating sum',200);
    }
}
