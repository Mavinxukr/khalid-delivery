<?php


namespace App\Repositories\Company;


use App\Contracts\Company\Service\CompanyServiceInterface;
use App\Contracts\FormatInterface;
use App\Helpers\ActionSaveImage;
use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Models\Category\ProductCategory;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class CompanyServiceRepository implements CompanyServiceInterface
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

    public function storeSuggestCategory(Request $request)
    {
       ProductCategory::create([
           'active' => false,
           'type'   => $request->title,
           'cause'  => $request->cause
       ]);
       return TransJsonResponse::toJson(true,null,
                    'Success, your category pending',200);
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
