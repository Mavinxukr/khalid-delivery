<?php


namespace App\Repositories\Client;


use App\Helpers\ActionOverOrder;
use App\Helpers\FoodOrderHelper;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Order\OrderFoodInterface;
use App\Contracts\FormatInterface;
use App\Models\Order\Order;
use App\Models\Order\OrderStatus;
use App\Models\Provider\Provider;
use App\Traits\FeeTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderFoodRepository implements OrderFoodInterface
{
    public function show(int $id)
    {
        $order = Order::findOrFail($id);
        $response =  $this->format($order);
        return TransJsonResponse::toJson(true,$response,'Show order',200);
    }

    public function store($data)
    {
        $place = $data->user()
                        ->place()
                        ->find($data->place_id);
        if (is_null($place))
                    return TransJsonResponse::toJson(false, null,
                                'Place id not found', 404);

        if (count($data->user()->curt) > 0 ) {
            $order = Order::create($data->all() +
                [
                    'user_id' => $data->user()->id,
                    'date_delivery_to' => 'empty'
                ]
            );
            $providerId = null;
            $cost = 0;
            $minOrder = 0;
            foreach ($data->user()->curt as $item){
                if (!is_null($item->product->provider)) {
                    if($item->product->provider->providerSetting)
                    {
                        $minOrder = intval($item->product->provider->providerSetting->min_order);
                    }
                    $providerId = $item->product->provider->id;
                    break;
                }
            }

            foreach ($data->user()->curt as $item) {
                $cost += $item->product->price * $item->quantity;
                $order->products()->attach($item->product->id, ['quantity' => $item->quantity]);
                $item->delete();
            }

            if($minOrder !== 0 && $cost < $minOrder){
                return TransJsonResponse::toJson(false, null,
                    'Minimum order cost is ' . $minOrder . '$', 400);
            }

            foreach ($data->user()->curt as $item) {
                $item->delete();
            }
            if($cost){
                $order->initial_cost = $cost;
                $costs = (new FoodOrderHelper())->calculateCost($providerId, $cost);

                $order->cost = $costs['cost'];
                $order->service_received = $costs['service_received'];
                $order->company_received = $costs['company_received'];
            }else{
                $order->cost = $cost;
            }

            $order->provider_id = $providerId;
            if ($order->provider->percent ){
                $order->cost *= ($order->provider->count /100)  ;
            }else{
                $order->cost += $order->provider->count;
            }
            $order->provider_category = 'food';
            $order->debt = $order->cost;
            if($order->payment_type === 'cash')
                $order->status = 'new';

            $order->status_id = OrderStatus::whereName('New')->first()->id;

            //проверка на маркет
            if (!is_null($providerId)){
                $provider_type = Provider::find($providerId)->categories->type;
                if($provider_type == "market"){
                    $order->initial_cost = null;
                    $order->cost = null;
                    $order->debt = null;
                    $order->service_received = null;
                    $order->company_received = null;
                }
            }

            if (!is_null($order->provider_category) && $order->provider_category == 'market' ||
                $order->provider_category == 'food'){
                $order->status = 'confirm';
            }
            $order->save();
            $response = $this->format($order);
            return TransJsonResponse::toJson(true, $response, 'Order was created', 201);
        }else{
            return TransJsonResponse::toJson(false, null,
                'Your curt is empty, nothing to confirm ', 400);
        }
    }

    public function confirmOrder($request)
    {
        try {
            $confirm  = ActionOverOrder::confirmOrder($request);
            return TransJsonResponse::toJson(true, null, $confirm, 201);
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false, null, $exception->getMessage(), 400);
        }
    }


    public function cancelOrder($request)
    {
        try {
            $cancel  = ActionOverOrder::cancelOrder($request);
            return TransJsonResponse::toJson(true, null, $cancel, 201);
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false, null, $exception->getMessage(), 400);
        }
    }

    public function restoreOrder(int $id)
    {
        $order                       = Order::findOrFail($id);
        $restore                     = $order->replicate();
        $restore->save();

        $restore->update([
            'name'                  =>'Restore_'.$order->name,
            'date_delivery'         => Carbon::now()->toDateString(),
            'date_delivery_from'    => Carbon::now()->format('H:m:s'),
            'status'                => 'wait'
        ]);
        $restore->products()->attach($order->products()->get()->pluck('id'));

        return TransJsonResponse::toJson(true, null, 'Restore successfully', 201);
    }

    public function doneOrder($request)
    {
        try {
            $done  = ActionOverOrder::doneOrder($request);
            return TransJsonResponse::toJson(true, null, $done, 201);
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false, null, $exception->getMessage(), 400);
        }
    }

    public function format($data)
    {
        return [
            'id'             => $data->id,
            'name'           => $data->name,
            'company_name'   => $data->provider->name ?? null,
            'date'           => Carbon::make($data->date_delivery)->format('Y-m-d'),
            'time_from'      => $data->date_delivery_from,
            'address'        => $data->place->address,
            'city'           => $data->place->city,
            'price'          => $data->cost,
            'zip'            => $data->place->postal_code,
            'country_code'   => $data->place->country,
            'callback'       => $data->callback_time,
            'status'         => $data->status ?? 'wait',
             'delivery_status'=> !is_null($data->delivery_status) ? [
        'status' => $data->delivery_status->name,
        'step'   => $data->delivery_status->step,
    ] : null,
            'comment'        => $data->comment
        ];
    }
}
