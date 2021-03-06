<?php


namespace App\Repositories\Client;


use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Product\ProductInterface;
use App\Contracts\FormatInterface;
use App\Models\Category\Category;
use App\Models\Category\ProductCategory;
use App\Models\Product\Product;
use App\Models\Provider\Provider;
use phpDocumentor\Reflection\Types\Null_;

class ProductRepository implements ProductInterface
{

    public function indexServices(string $type)
    {
        $products = null;
        $category = Category::whereType($type)->first();
        if ($type == 'service'){
            $products = Product::whereType($type)
                ->get()
                ->map(function ($service){
                    return $this->format($service);
                });
        }elseif ($type == 'food'){
            $products = Provider::whereCategoryId($category->id)
                ->get()
                ->map(function ($item){
                    return $this->format($item);
                });
        }
        else{
            $products = Provider::whereCategoryId($category->id)
                ->get()
                ->map(function ($item){
                    return $this->format($item);
                });
        }
        return TransJsonResponse::toJson(true,$products,'Show all', 200);
    }

    public function show(int $id)
    {
      $restaurant = Provider::findOrFail($id);

      return TransJsonResponse::toJson(true,$this->format($restaurant),
                                        'Get by ID one restaurant', 200);
    }

    public function showByCategory(int $provider_id, int $category_id)
    {
        $menus = Provider::findOrFail($provider_id)
                        ->product()
                         ->where('category_id', $category_id)
                         ->get()
                         ->map(function ($menu){
                             return $this->format($menu);
                         });
        return TransJsonResponse::toJson(true,$menus,'All providers\' product by category',200);
    }

    public function showBySortType(int $provider_id, string $sort_type)
    {
        $menus = Provider::findOrFail($provider_id)
            ->product()
            ->where($sort_type, 1)
            ->get()
            ->map(function ($menu){
                return $this->format($menu);
            });
        return TransJsonResponse::toJson(true,$menus,'All providers\' product by sort type',200);
    }

    public function showServiceCategory(int $service_id)
    {
        $categories = Product::whereProviderId($service_id)
                                ->get(['category_id']);
        $unique = $categories->unique('category_id')
                                ->values()
                                ->pluck('category_id');
        $result = ProductCategory::whereIn('id',$unique)
                                ->whereActive(true)
                                ->get()
                                ->map(function ($item){
                                    return [
                                        'id'    => $item->id,
                                        'name'  => $item->type,
                                        'image' => ImageLinker::linker($item->image),
                                    ];
                                });
        return TransJsonResponse::toJson(true,$result,
            'All categories for menu by restaurant id',200);

    }

    public function format($data)
    {
        $result = [];

        if ($data instanceof Provider){
            $topProduct =  $data->productTop()
                    ->get([
                        'id','title','price',
                        'description','image','weight',
                    ]) ?? null;

            $array = [];
            foreach ($data->product()->get() as $i){
                if (!empty($i->categories)){
                    $array[] = $i->categories->id;
                }
            }
            $result = [
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
                'count_menu'        => count(array_unique($array)) ?? 0,
                'top_product'       => $topProduct ?? null

            ];
        }else{
            $result =  [
                'id'                => $data->id,
                'title'             => $data->title ?? $data->name,
                'image'             => ImageLinker::linker($data->image),
                'description'       => $data->description ?? null,
                'price'             => $data->price,
                'weight'            => $data->weight,
                'what_is_included'  => $data->what_is_included,
                'what_is_not_included'  => $data->what_is_not_included,
                'info_pay'          => $data->info_pay,
                'query'             => $data->queries()->with('answers')->get(),
                'rating'            => $data->rating
            ];
        }
        return $result;
    }
}
