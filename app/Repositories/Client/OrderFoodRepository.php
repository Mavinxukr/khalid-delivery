<?php


namespace App\Repositories\Client;


use App\Helpers\ActionOverOrder;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Order\OrderFoodInterface;
use App\Contracts\FormatInterface;
use App\Models\Order\Order;
use Carbon\Carbon;

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
            foreach ($data->user()->curt as $item) {
                if (!is_null($item->product->provider)) {
                    $providerId = $item->product->provider
                                  ->value('id');
                }
                $order->cost += $item->product->price * $item->quantity;
                $order->products()->attach($item->product->id, ['quantity' => $item->quantity]);
                $item->delete();
            }
            $order->provider_id = $providerId;
            $order->provider_category = 'food';
            $order->debt = $order->cost;
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
        $confirm  = ActionOverOrder::confirmOrder($request);
        return TransJsonResponse::toJson(true, null, $confirm, 201);
    }


    public function cancelOrder($request)
    {
        $cancel  = ActionOverOrder::cancelOrder($request);
        return TransJsonResponse::toJson(true, null, $cancel, 201);

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
            'status'         => $data->status ?? 'wait'
        ];
    }
}
