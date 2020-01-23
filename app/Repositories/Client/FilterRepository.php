<?php


namespace App\Repositories\Client;


use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Product\FilterInterface;
use App\Contracts\FormatInterface;
use App\Models\Category\Category;
use App\Models\Provider\Kitchen;
use App\Models\Provider\Provider;
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
            'name'              => $data->title ?? $data->name,
            'image'             => ImageLinker::linker($data->image),
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
                $companies->where('setting_providers.rating','=',$data->get('rating'));
            }
            if ($data->has('price_rating')){
                $companies->where('setting_providers.price_rating','=',$data->get('price_rating'));
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
}
