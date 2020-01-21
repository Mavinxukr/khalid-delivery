<?php


namespace App\Repositories\Company;


use App\Contracts\Company\Service\CompanyServiceInterface;
use App\Contracts\FormatInterface;
use App\Helpers\ActionSaveImage;
use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class CompanyServiceRepository implements CompanyServiceInterface, FormatInterface
{

    public function create(Request $request)
    {
       $product =  Product::create($request->all() +
            [
                'type'          => 'service',
                'active'        =>  false,
                'provider_id'   =>  $request->user()->company->id,
            ]);
        $product->image = ActionSaveImage::updateOrCreateImage($request->image, $product , 'product');
        $product->save();

        return TransJsonResponse::toJson(true,$this->format($product),
            'Exclusive was create',200);
    }

    public function format($data)
    {
        return [
            'id'            => $data->id,
            'title'         => $data->title,
            'price'         => $data->price,
            'description'   => $data->description,
            'image'         => ImageLinker::linker($data->image),
        ];
    }
}
