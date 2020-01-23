<?php


namespace App\Repositories\Company;


use App\Contracts\Company\Order\FoodOrderInterface;
use App\Helpers\GeoLocationHelper;
use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Models\Order\Order;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FoodOrderRepository implements FoodOrderInterface
{

    public function getAllOrder(Request $request)
    {
        if (!is_null($request->user()->company->geoLocation)) {
            $orderIds = GeoLocationHelper::getOrderIds($request, 'food');
            $orders = Order::whereIn('id', $orderIds)
                ->whereIn('status', [$request->status])
                ->where('provider_id', '=', $request->user()->company->id)
                ->get()
                ->map(function ($item) use ($request) {
                    return $this->format($item);
                });
            return TransJsonResponse::toJson(true, $orders,
                'Show orders by your geolocation', 200);
        }else{
            return TransJsonResponse::toJson(false, null,
                'You have not geolocation', 400);
        }
    }

    public function getOrderById(Request $request, int $id)
    {
        $order = Order::findOrFail($id);

        $products = $order->products()
                          ->get()
                          ->map(function ($product){
                              $product->flag = true;
                                return $this->format($product);
                          });
        return TransJsonResponse::toJson(true, $products,'Show order by id', 200);
    }

    public function getProductInOrderById(Request $request, int $order_id, int $product_id)
    {
      $product =  Order::findOrFail($order_id)
                        ->products()
                        ->findOrFail($product_id);
        return TransJsonResponse::toJson(true, $product,'Show product in order by id', 200);
    }

    public function format($data)
    {
        if ($data->flag){
            return [
                'id'                 => $data->id,
                'name'               => $data->title,
                'cost'               => $data->price,
                'image'              => ImageLinker::linker($data->image),
                'category'           => $data->categories->type
            ];
        }else{
            return [
                'id'                 => $data->id,
                'name'               => $data->name,
                'place'              => $data->place,
                'date_delivery'      => $data->date_delivery->toDateString(),
                'date_delivery_from' => $data->date_delivery_from,
                'cost'               => $data->cost,
                'image'              => ImageLinker::linker($data->products()->value('image'))
            ];
        }

    }

}
