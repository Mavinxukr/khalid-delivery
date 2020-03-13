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
            $orders = Order::whereProviderId($request->user()->company->id)
                //->whereIn('status', [$request->status])
                ->get()
                ->map(function ($item) use ($request) {
                    return $this->format($item);
                });
            return TransJsonResponse::toJson(true, $orders,
                'Show your orders', 200);

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
      $product->flag = true;

        return TransJsonResponse::toJson(true, $this->format($product),'Show product in order by id', 200);
    }


    public function takeFoodOrder(Request $request)
    {
        $order =  Order::findOrFail($request->order_id);

        if ($order->status === 'new'){
            $order ->update([
                'status'    => 'confirm'
            ]);
            return TransJsonResponse::toJson(true, null,'Food order confirm success', 200);
        }else{
            return TransJsonResponse::toJson(false, null,
                "Food order not confirm, because order status  - $order->status ", 400);
        }
    }

    public function doneFoodOrder(Request $request)
    {
        $order =  Order::findOrFail($request->order_id);

        if ($order->status === 'confirm'){
            $order ->update([
                'status'    => 'done'
            ]);

            //here need to send push-notify
            return TransJsonResponse::toJson(true, null,'Food order done success', 200);
        }else{
            return TransJsonResponse::toJson(false, null,
                "Food order not done, because order status  - $order->status ", 400);
        }
    }


    public function format($data)
    {
        if ($data->flag){
            return [
                'id'                 => $data->id,
                'name'               => $data->title,
                'cost'               => $data->price,
                'image'              => ImageLinker::linker($data->image),
                'category'           => $data->categories->type,
                'description'        => $data->description,
                'weight'             => $data->weight
            ];
        }else{
            return [
                'id'                 => $data->id,
                'name'               => $data->name,
                'place'              => $data->place,
                'date_delivery'      => $data->date_delivery->toDateString(),
                'date_delivery_from' => $data->date_delivery_from,
                'cost'               => $data->cost,
                'image'              => ImageLinker::linker($data->products()->value('image')),
                'status'             => $data->status,
                'comment'            => $data->comment,
                'callback_time'      => $data->callback_time
            ];
        }
    }

    public function cancelFoodOrder(Request $request, int $id)
    {
        $order =  Order::findOrFail($id);
        if ($order->status === 'confirm'){
            $order ->update([
                'status'    => 'new'
            ]);
            //here need to send push-notify
            return TransJsonResponse::toJson(true, null,'Food order cancel success', 200);
        }else{
            return TransJsonResponse::toJson(false, null,
                "Food order not done, because order status  - $order->status ", 400);
        }
    }

    public function getFoodOrderWithOutStatus(Request $request)
    {
        $orders = Order::whereProviderId($request->user()->company->id)
            ->get()
            ->map(function ($item) use ($request) {
                return $this->format($item);
            });
        return TransJsonResponse::toJson(true, $orders,
            'Show your order with no status', 200);

    }
}
