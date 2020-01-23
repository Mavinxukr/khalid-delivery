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
                'image'             => ImageLinker::linker($data->image)
            ];
        }else{
            $result =  [
                'id'                => $data->id,
                'name'              => $data->title,
                'price'             => $data->price,
                'description'       => $data->description,
                'image'             => ImageLinker::linker($data->image),
                'has_ingredients'   => $data->has_ingredients,
                'weight'            => $data->weight,
                'ingredients'       => $data->component
            ];
        }
            return $result;

    }
}
