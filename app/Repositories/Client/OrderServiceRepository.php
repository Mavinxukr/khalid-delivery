<?php


namespace App\Repositories\Client;


use App\Helpers\ActionOverOrder;
use App\Helpers\TransJsonResponse;
use App\Interfaces\Client\Order\OrderServiceInterface;
use App\Interfaces\FormatInterface;
use App\Models\Feedback\FirePush;
use App\Models\Order\CancelOrder;
use App\Models\Order\Order;
use Carbon\Carbon;

class OrderServiceRepository implements OrderServiceInterface, FormatInterface
{

    public function store($data)
    {
        $order = Order::create($data->all() +
            [
                'user_id' => $data->user()->id
            ]
        );

        $type = $order->product->type;
        if ($type  == 'service'){
            $order->provider_id     =  null ;
            $order->cost =  $order->count_clean *
                    ($order->product->price * $order->quantity) ;
        }

        $order->provider_category   =  $type;
        $order->debt                =  $order->cost;
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
            'status'         => $data->status ?? 'wait'
        ];

    }
}
