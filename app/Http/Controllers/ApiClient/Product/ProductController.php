<?php

namespace App\Http\Controllers\ApiClient\Product;

use App\Http\Controllers\Controller;
use App\Contracts\Client\Product\ProductInterface;
use App\Contracts\Client\Product\SingleProductInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product;
    private $singleProduct;

    public function __construct(
        ProductInterface $product,
        SingleProductInterface $singleProduct
    )
    {
        $this->product       = $product;
        $this->singleProduct = $singleProduct;
    }

    /**
     * @api {get} client/services/{food/service/market}  Show services #Screen №1,10,34
     * @apiName  Show services
     * @apiVersion 1.1.1
     * @apiGroup Client Service
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/services/{food/service/market}
     */
    public function indexServices(Request $request)
    {
        return $this->product->indexServices($request->type);

    }

    /**
     * @api {get} client/services/get/{id} Show service #Screen №11,35
     * @apiName  Show service
     * @apiVersion 1.1.1
     * @apiGroup Client Service
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/services/get/{id}
     */

    public function show(int $id)
    {
        return $this->product->show($id);
    }

    /**
     * @api {get} client/services/menus/{provider_id}/{category_id} Show service menu by category #Screen №13,37
     * @apiName  Show service menu by category
     * @apiVersion 1.1.1
     * @apiGroup Client Service
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest client/services/menus/{provider_id}/{category_id}
     */

    public function showByCategory(int $id, int $category)
    {
        return $this->product->showByCategory($id ,$category);
    }

    /**
     * @api {get} client/services/categories/{service_id} Show service categories #Screen №12, 36
     * @apiName  Show service categories
     * @apiVersion 1.1.1
     * @apiGroup Client Service
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest client/services/categories/{service_id}
     */

    public function showServiceCategory(int $provider_id)
    {
        return $this->product->showServiceCategory($provider_id);
    }


    /**
     * @api {get} client/services/product/{id} Show product by id #Screen №15,38
     * @apiName Show product by id
     * @apiVersion 1.1.1
     * @apiGroup Client Product
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest client/services/product/{id}
     */


    public function getProductComponent(int $id)
    {
        return $this->singleProduct->show($id);
    }
}
