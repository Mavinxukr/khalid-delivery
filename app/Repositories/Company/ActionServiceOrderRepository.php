<?php


namespace App\Repositories\Company;


use App\Contracts\Company\Order\ActionServiceOrderInterface;
use App\Helpers\TransJsonResponse;
use App\Models\Order\Order;
use Illuminate\Http\Request;

class ActionServiceOrderRepository implements ActionServiceOrderInterface
{

    public function take(Request $request)
    {
        try {
            Order::whereId($request->order_id)
                ->whereStatus('new')
                ->whereNull('provider_id')
                ->update([
                    'provider_id' => $request->user()->company->id,
                    'status'      => 'confirm'
                ]);
            return TransJsonResponse::toJson(true,null,'You just took the order',200);
        }catch (\Exception $exception){
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

}
