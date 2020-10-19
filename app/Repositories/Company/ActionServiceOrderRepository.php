<?php


namespace App\Repositories\Company;


use App\Contracts\Company\Order\ActionServiceOrderInterface;
use App\Helpers\FileHelper;
use App\Helpers\PushHelper;
use App\Helpers\ServiceOrderHelper;
use App\Helpers\TransJsonResponse;
use App\Models\Order\Order;
use App\Traits\FeeTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActionServiceOrderRepository implements ActionServiceOrderInterface
{
    use FeeTrait;

    public function take(Request $request)
    {
        try {
            $order =  Order::whereId($request->order_id)
                ->whereStatus('confirm')
                ->whereNull('provider_id')
                ->update([
                    'provider_id' => $request->user()->company->id,
                //    'status'      => 'confirm',
                ]);

            if ($order){
                $rewOrder = Order::findOrFail($request->order_id);

                if ($rewOrder->provider->reward){
                    $bonus = $rewOrder->initial_cost * 0.01 > 10 ? 10 : $rewOrder->initial_cost * 0.01;
                    $this->rewardAction($rewOrder, $bonus);
                }
            }

            return TransJsonResponse::toJson(true,null,'You just took the order',200);
        }
        catch (\Exception $exception){
            return TransJsonResponse::toJson(false,null,'Something went wrong',400);
        }

    }

    public function cancel(Request $request, int $id)
    {
        try {
            Order::whereProviderId($request->user()->company->id)
                ->whereStatus('confirm')
                ->whereId($id)
                ->update([
                    'provider_id' => null,
                    'status'      => 'new'
                ]);
            return TransJsonResponse::toJson(true,null,'You just cancel the order',200);
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false,null,'Something went wrong',400);
        }

    }

    public function format($data){}

    public function doneServiceOrder(Request $request)
    {
        $order =  Order::findOrFail($request->order_id);

        if ($order->status === 'confirm'){

            $order ->update([
                'status'    => 'done'
            ]);

                foreach ($order->extends->all() as $extend){
                    $extend->update([
                        'accepted' => 'completed',
                    ]);
            }

            //here need to send push-notify
            return TransJsonResponse::toJson(true, null,'Service order done success', 200);
        }else{
            return TransJsonResponse::toJson(false, null,
                "Service order not done, because order status  - $order->status ", 400);
        }
    }

    public function sendMyLocation(Request $request, int $id)
    {
        $order = Order::findOrFail($id);

        $order->locationHistory()->create($request->all() + [
            'user_id' => $request->user()->id
        ]);

        return TransJsonResponse::toJson(true, null,'Location save success', 200);
    }

    public function extendServiceOrder(Request $request, int $id)
    {
        $order = Order::findOrFail($id);

        $cost = $order->product->price;
        $costs['cost'] = 0;
        $costs['service_received'] = 0;
        $costs['company_received'] = 0;

        $time_from = Carbon::createFromFormat('H:m:i', $order->date_delivery_from);
        $time_to = Carbon::createFromFormat('H:m:i', $request->extend_to);

        $time = $time_to->diffInMinutes($time_from);
        $attitude = $time/60;

        if($order->preOrder){
            $cost = ($cost + $order->preOrder->price) * $attitude;
        }else{
            $cost = $cost * $attitude;
        }

        if($cost) $costs = (new ServiceOrderHelper())->calculateCost($cost);

        $extend = $order->extends()->updateOrCreate(['extend_to' => $request->extend_to ],[
            'extend_from'       => $order->date_delivery_to,
            'extend_to'         => $request->extend_to,
            'service_received'  => $costs['service_received'],
            'company_received'  => $costs['company_received'],
            'initial_cost'      => $cost,
            'cost'              => $costs['cost'],
            'reason'            => $request->reason,
        ]);
        if(!is_null($request->all()['files'])){
            foreach ($request->all()['files'] as $item){
                $file = FileHelper::store($item, '/orders/extends/');
                $extend->files()->create([
                    'link' => $file
                ]);
            }
        }

        PushHelper::sendPush($order->user_id, 'Service Provider request to extend order');

        return TransJsonResponse::toJson(true, null,'Request sent success', 200);
    }
}
