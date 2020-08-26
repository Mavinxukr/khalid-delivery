<?php


namespace App\Repositories\Client;


use App\Helpers\ActionOverOrder;
use App\Helpers\ServiceOrderHelper;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Order\OrderServiceInterface;
use App\Models\Order\Order;
use App\Models\Order\OrderExtend;
use App\Traits\FeeTrait;
use Carbon\Carbon;

class OrderServiceRepository implements OrderServiceInterface
{
    use FeeTrait;

    public function store($data)
    {
        $place = $data->user()
                        ->place()
                        ->find($data->place_id);
        if (is_null($place))
            return TransJsonResponse::toJson(false, null,
                'Place id not found', 404);
        $order = Order::create($data->all() +
            [
                'user_id' => $data->user()->id
            ]
        );

        $type = $order->product->type;
        if ($type  == 'service'){
            $preOrder = $this->storePreOrder($data);
            $cost = $order->product->price;
            if(!is_null($preOrder)){
                    $time_from = Carbon::createFromFormat('H:m:i', $data->date_delivery_from);
                    $time_to = Carbon::createFromFormat('H:m:i', $data->date_delivery_to);

                    $time = $time_to->diffInMinutes($time_from);
                    $attitude = $time/60;

                    $cost = ($cost + $preOrder->price) * $attitude;
                    foreach ($preOrder->details as $item){
                        $item->update(['order_id' => $order->id]);
                    }
            }
            $order->provider_id  =  null;
            $order->initial_cost = $cost;

            if(!is_null($order->provider_id)){
                if ($order->provider->percent){
                    $order->initial_cost *= ($order->provider->count /100)  ;
                }else{
                    $order->initial_cost += $order->provider->count;
                }
            }
        }

        $costs = (new ServiceOrderHelper())->calculateCost($cost);
        $order->cost =  $costs['cost'];
        $order->service_received = $costs['service_received'];
        $order->company_received = $costs['company_received'];

        $order->provider_category   = $type;
        $order->debt                = $order->cost;
        if($order->payment_type === 'cash') $order->status = 'new';
        $order->save();
        $response =  $this->format($order);
        return TransJsonResponse::toJson(true,$response,'Order was created',201);
    }

    public function show(int $id)
    {
        $order = Order::findOrFail($id);
        $response =  $this->format($order);
        return TransJsonResponse::toJson(true,$response,'Show order',200);

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
            'status'                => 'wait'
        ]);
        return TransJsonResponse::toJson(true, null, 'Restore successfully', 201);
    }

    public function format($data)
    {
        return [
            'id'             => $data->id,
            'name'           => $data->name,
            'company_name'   => $data->provider->name ?? null,
            'date'           => Carbon::make($data->date_delivery)->format('Y-m-d'),
            'time_from'      => $data->date_delivery_from,
            'time_to'        => $data->date_delivery_to,
            'address'        => $data->place->address,
            'city'           => $data->place->city,
            'price'          => $data->cost,
            'zip'            => $data->place->postal_code,
            'country_code'   => $data->place->country,
            'callback'       => $data->callback_time,
            'status'         => $data->status ?? 'wait',
            'comment'        => $data->comment
        ];

    }

    public function storePreOrder($data)
    {
        $preOrder = $data->user()->preOrder()->create();
        $answers = explode(';', $data->answers);

        foreach ($answers as $k => $item) {
            $values = explode(',', $item);
            foreach ($values as $value) {
                $temp = explode('=', $value);
                $params[$temp[0]] = $temp[1];
            }
            $preOrder->details()->create([
                'query_id' => $params['q'],
                'answer_id' => $params['a'],
            ]);
        }

        $sum = 0;
        foreach ($preOrder->details as $query){
            $sum = $sum + ($query->answer->price);
        }

        $preOrder->update([
            'price'     => $sum,
            'status'    => 'pre-order',
        ]);

        return $preOrder->fresh();
    }

    public function showRequests(int $id)
    {
        $order = Order::findOrFail($id);
        $extends = $order->extends()->with('files')->get();
        return TransJsonResponse::toJson(true, $extends, 'All Requests', 200);
    }

    public function acceptRequest(int $id)
    {
        $extend = OrderExtend::findOrFail($id);
        $extend->update([
            'accepted' => 1,
        ]);

        $extend->order()->update([
            'initial_cost'      => $extend->initial_cost,
            'cost'              => $extend->cost,
            'service_received'  => $extend->service_received,
            'company_received'  => $extend->company_received,
            'debt'              => $extend->cost,
            'date_delivery_to'  => $extend->extend_to,
        ]);
        return TransJsonResponse::toJson(true, null, 'Request accepted', 200);
    }

    public function declineRequest(int $id)
    {
        $extend = OrderExtend::findOrFail($id);
        $extend->update([
            'accepted' => 'confirmed',
        ]);
        return TransJsonResponse::toJson(true, null, 'Request declined', 200);
    }
}
