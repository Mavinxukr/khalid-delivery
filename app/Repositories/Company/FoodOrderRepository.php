<?php


namespace App\Repositories\Company;


use App\Contracts\Company\Order\FoodOrderInterface;
use App\Helpers\FileHelper;
use App\Helpers\FoodOrderHelper;
use App\Helpers\GeoLocationHelper;
use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Models\Order\CancelOrderItem;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Notifications\SendNotification;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;

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
                          ->withPivot('canceled')
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

            $headers = \App\Models\Invoice\InvoiceTemplate::all()->pluck('value', 'key');
            User::findOrFail($order->user_id)->notify(new SendNotification((new MailMessage)
                ->view('tax.simple', [
                    'order'     => $order,
                    'headers'   => $headers,
                ])));

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
                'weight'             => $data->weight,
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

    public function cancelFoodOrderItems(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if(is_null($request->product_ids)){
            return TransJsonResponse::toJson(false,[],'Any product selected', 400);
        }

        $ids = explode(',', $request->product_ids);
        $order->products()->whereIn('product_id', $ids)->update([
            'canceled' => 1,
        ]);

        $image = null;
        if(!is_null($request->image)){
            $image = FileHelper::store($request->image, 'food');
        }

        CancelOrderItem::updateOrCreate(['order_id' => $id], [
            'description'   => $request->description,
            'image'         => $image
        ]);

        $products = $order->products()
            ->withPivot(['canceled', 'quantity'])
            ->get();

        $cost = 0;
        foreach ($products as $item) {
            if(!$item->pivot->canceled){
                $cost += $item->price * $item->pivot->quantity;
             }
        }

        $costs = (new FoodOrderHelper())->calculateCost($order->provider_id, $cost);

        $order->cost = $costs['cost'];
        $order->service_received = $costs['service_received'];
        $order->company_received = $costs['company_received'];
        $order->save();

        $products = $order->products()
            ->where('canceled', 0)
            ->get()
            ->map(function ($product){
                $product->flag = true;
                return $this->format($product);
            });

        return TransJsonResponse::toJson(true, $products,'Show order by id', 200);
    }
}
