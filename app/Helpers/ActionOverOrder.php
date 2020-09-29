<?php


namespace App\Helpers;

use App\Models\Checkout\Checkout;
use App\Models\Feedback\FirePush;
use App\Models\Order\CancelOrder;
use App\Models\Order\Order;
use Carbon\Carbon;

class ActionOverOrder extends CheckoutHelper
{
    public static function confirmOrder($request)
    {
        $order =  Order::whereId($request->id)
                        ->whereUserId($request->user()->id)
                        ->first();
        if (!is_null($order) ) {
            if ($order->status == 'wait' || $order->status == 'new' ) {
                if (!is_null($order->provider_category) && $order->provider_category  == 'service'){
                    $checkout = self::checkoutOrder($request, $order);
                    if (!$checkout) {
                        throw new \Exception("Error with you payment ! \n {$order->checkout->message}");
                    }
                }

                self::validateCancel($order);
                $order->status = 'confirm';
                $order->save();
                return 'Order was confirmed';
            } else {
                 throw new \Exception('You already confirm this order');
            }
        }else{
            return abort(404);
        }
    }

    public static function doneOrder($request)
    {
        $order =  Order::whereId($request->id)
            ->whereUserId($request->user()->id)
            ->first();
        if (!is_null($order)) {
            if ($order->status === 'confirm' && $order->delivery_status->name === 'delivered'){
                $order ->update([
                    'status'    => 'done',
                ]);
                return 'Order was done';
            } else {
                throw new \Exception('You already done this order');
            }
        }else{
            return abort(404);
        }
    }

    public static function cancelOrder($request)
    {
        $order = Order::findOrFail($request->id);
        if (!in_array($order->status,['wait','cancel'])){
            $timeNow = Carbon::now()->toDateTimeString();
            $confirmTime = $order->cancelOrderTime->confirm_time;
            if ($confirmTime >= $timeNow){
                    //self::refundOrder($request, $order);
                    $order->status = 'cancel';
                    $order->save();
                    return 'Your order was canceled without commissions !';
            }else{
                throw new \Exception('You can not cancel order, because already less than 30 min before start order !');
            }
        }else{
            if ($order->status === 'wait'){
                throw new \Exception('This order does not confirm yet');
            }else{
                throw new \Exception('You already cancel this order');
            }

        }
    }

    private static function validateCancel(Order $order) :void
    {
        $year = Carbon::make($order->date_delivery)->year;
        $month = Carbon::make($order->date_delivery)->month;
        $day = Carbon::make($order->date_delivery)->day;
        $hour = Carbon::createFromFormat('H:i:s', $order->date_delivery_from)
            ->addMinutes(-30);
        $string = "$year-$month-$day $hour->hour:$hour->minute:$hour->second";

        CancelOrder::create([
            'confirm_time' => Carbon::make($string)->toDateTimeString(),
            'order_id'     => $order->id
        ]);
    }

    private static function pushFireTime(Order $order) :void
    {
        $year = Carbon::make($order->date_delivery)->year;
        $month = Carbon::make($order->date_delivery)->month;
        $day = Carbon::make($order->date_delivery)->day;
        $hour = Carbon::createFromFormat('H:i:s', $order->date_delivery_to);
        $string = "$year-$month-$day $hour->hour:$hour->minute:$hour->second";

        FirePush::create([
            'time'          => Carbon::make($string)->toDateTimeString(),
            'order_id'      => $order->id,
            'user_id'       => $order->user_id,
            'date'          => Carbon::make("$year-$month-$day")->toDateString()
        ]);
    }

}
