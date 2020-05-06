<?php


namespace App\Repositories\Client;


use App\Helpers\ActionOverOrder;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Order\OrderServiceInterface;
use App\Contracts\FormatInterface;
use App\Models\Feedback\FirePush;
use App\Models\Order\CancelOrder;
use App\Models\Order\Order;
use App\Notifications\SendNotification;
use App\Traits\FeeTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;

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
            $price = $order->product->price;
            if(!is_null($preOrder)){
                    $price = $price + $preOrder->price;
                    foreach ($preOrder->details as $item){
                        $item->update(['order_id' => $order->id]);
                    }
            }

            $order->provider_id     =  null ;
            $order->initial_cost = $price;
            $cost =  $order->initial_cost + $this->getFee($type, 'charge');
            $order->cost =  $cost + ($cost / 100 * $this->getFee($type, 'vat'));
        }

        $order->provider_category   = $type;
        $order->service_received    = ($order->initial_cost / 100 *
                $this->getFee($type, 'received')) / 100 *
                $this->getFee($type, 'vat');
        $order->company_received    = $order->cost - $order->service_received;
        $order->debt                = $order->cost;
        if($order->payment_type === 'cash' || $order->payment_type === 'b2b')
            $order->status = 'new';

        $order->save();

        if($order->payment_type === 'cash' ){
            $headers = \App\Models\Invoice\InvoiceTemplate::all()->pluck('value', 'key');
            $data->user()->notify(new SendNotification((new MailMessage)
                ->view('tax.simple', [
                    'order'     => $order,
                    'headers'   => $headers,
                ])));
        }
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
            'status'         => $data->status ?? 'wait'
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
}
