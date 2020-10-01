<?php


namespace App\Repositories\Company;


use App\Contracts\Company\Order\ServiceOrderInterface;
use App\Helpers\GeoLocationHelper;
use App\Helpers\TransJsonResponse;
use App\Models\Order\Order;
use Illuminate\Http\Request;

class ServiceOrderRepository implements ServiceOrderInterface
{
    public function getAllOrder(Request $request)
    {
        if (!is_null($request->user()->company->geoLocation)) {
            $orderIds = GeoLocationHelper::getOrderIds($request, 'service');
            $orders = Order::whereIn('id', $orderIds)
                ->where('status', "=","confirm")
                ->whereNull('provider_id')
                ->orWhere('provider_id', '=', $request->user()->company->id)
                ->get()
                ->map(function ($item) use ($request) {
                    $item->company_id = $request->user()->company->id;
                    return $this->format($item);
                });
            return TransJsonResponse::toJson(true, $orders,
                'Show orders by your geolocation', 200);
        }else{
            return TransJsonResponse::toJson(false, null,
                'You have not geolocation', 400);
        }
    }




    public function getOneOrder(Request $request, int $id)
    {
       $order = Order::whereId($id)
                        ->whereIn('status',['new','confirm'])
                        ->whereNull('provider_id')
                        ->orWhere('provider_id','=',$request->user()->company->id)
                        ->get()
                        ->map(function ($item) use($request){
                            $item->company_id = $request->user()->company->id;
                            return $this->format($item);
                        });
        return TransJsonResponse::toJson(true, $order,
                            'Show one order by your geolocation',200);
    }

    public function getAllOrderByFilters(Request $request)
    {
        if (!is_null($request->user()->company->geoLocation)) {
            $orderIds = GeoLocationHelper::getOrderIds($request, 'service');
            $orders = Order::query()
                ->whereIn('id', $orderIds)
                ->whereIn('status', ['new'])
                ->whereNull('provider_id');
            $result = null;

            if (!count($request->all())) {
                $result = $orders->get()
                    ->map(function ($item) use ($request) {
                        $item->company_id = $request->user()->company->id;
                        return $this->format($item);
                    });
            } else {
                if ($request->has('price_from')) {
                    $orders->where('cost', '>=', $request->price_from);
                }
                if ($request->has('price_to')) {
                    $orders->where('cost', '<=', $request->price_to);
                }

                $result = $orders->select('orders.*')
                    ->get()
                    ->map(function ($item) use ($request) {
                        $item->company_id = $request->user()->company->id;
                        return $this->format($item);
                    });
            }
            return TransJsonResponse::toJson(true, $result,
                'Show orders with filters by your geolocation', 200);
        }else{
            return TransJsonResponse::toJson(false, null,
                'You have not geolocation', 400);
        }
    }
    public function format($data)
    {
        return [
            'id'                => $data->id,
            'name'              => $data->name,
            'place'             => $data->place,
            'comment'           => $data->comment,
            'date_delivery'     => $data->date_delivery->toDateString(),
            'date_delivery_from'=> $data->date_delivery_from,
            'date_delivery_to'  => $data->date_delivery_to,
            'callback_time'     => $data->callback_time,
            'cost'              => $data->cost,
            'status'            => $data->status,
            'can_take'          => is_null($data->provider_id),
            'can_cancel'        => $data->company_id === $data->provider_id
        ];
    }

    public function getAllOrderNoGeo(Request $request)
    {
            $orders = Order::where('provider_id', '=', $request->user()->company->id)
                ->whereIn('status', ['new', 'confirm'])
                ->get()
                ->map(function ($item) use ($request) {
                    $item->company_id = $request->user()->company->id;
                    return $this->format($item);
                });
            return TransJsonResponse::toJson(true, $orders,
                'Show orders', 200);
    }
}
