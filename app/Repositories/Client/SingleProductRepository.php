<?php


namespace App\Repositories\Client;


use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Product\SingleProductInterface;
use App\Contracts\FormatInterface;
use App\Models\Product\Product;

class SingleProductRepository implements SingleProductInterface
{
    public function show(int $id)
    {
        $product = Product::findOrFail($id);
           return TransJsonResponse::toJson(true,$this->format($product),
               'Get product by id',200);
    }
    public function format($data)
    {
        if ($data->type === 'service'){
            return [
                'id'                => $data->id,
                'name'              => $data->title,
                'price'             => $data->price,
                'description'       => $data->description,
                'image'             => ImageLinker::linker($data->image),
                'what_is_included'  => $data->what_is_included,
                'what_is_not_included'  => $data->what_is_not_included,
                'info_pay'          => $data->info_pay,
                'query'             => $data->queries()->with('answers')->get(),
                'rating'            => $data->rating
            ];
        }else{

            $result =  [
                'id'                => $data->id,
                'title'             => $data->title,
                'price'             => $data->price,
                'description'       => $data->description,
                'image'             => ImageLinker::linker($data->image),
                'has_ingredients'   => $data->has_ingredients,
                'ingredients'       => $data->component,
                'query'             => $data->queries()->with('answers')->get(),
                'utils'             => !is_null($data->utils)? $data->utils->name : null
            ];

            $weight_info =[];
            if (!is_null($data->weight_info)){
                foreach ($data->weight_info as $key =>  $value){
                    $i = explode(':', $value);
                    $weight_info[$key]['weight'] = (float)head($i);
                    $weight_info[$key]['price'] = (int)end($i);
                }
            }

            if ($data->type == 'market'){
                $result['weight_info']  = $weight_info;
            }else{
                $result['weight'] = $data->weight;
            }
        }
            return $result;

    }
}
