<?php


namespace App\Repositories\Client;


use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Interfaces\Client\Product\SingleProductInterface;
use App\Interfaces\FormatInterface;
use App\Models\Product\Product;

class SingleProductRepository implements SingleProductInterface, FormatInterface
{

    public function format($data)
    {

        if ($data->type === 'service'){
            return [
                'id'                => $data->id,
                'name'              => $data->title,
                'price'             => $data->price,
                'description'       => $data->description,
                'image'             => ImageLinker::linker($data->image)
            ];
        }
        if ($data->type === 'food'){
            $result =  [
                'id'                => $data->id,
                'name'              => $data->title,
                'price'             => $data->price,
                'description'       => $data->description,
                'image'             => ImageLinker::linker($data->image),
                'has_ingredients'   => $data->has_ingredients
            ];
            if ($data->has_ingredients){
                $result['ingredients'] = $data->component;
            }
            return $result;
        }


    }

    public function show(int $id)
    {
        $product = Product::findOrFail($id);
           return TransJsonResponse::toJson(true,$this->format($product),
               'Get product by id',200);


    }
}
