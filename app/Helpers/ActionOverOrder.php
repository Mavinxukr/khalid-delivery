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
        if (!is_null($order)) {
            if ($order->status == 'wait') {
                $checkout = self::checkoutOrder($request, $order);
                if (isset($checkout->http_code) and $checkout->http_code < 400){
                    self::addToCheckout($checkout, $request, $order);
                    self::validateCancel($order);
                    $order->status = 'new';
                    $order->save();
                    return 'Order was confirmed';
                }else{
                    throw new \Exception('Problems with payment or card token expired - repeat the request !');
                }
            } else {
                 throw new \Exception('You already confirm this order');
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
                $checkout = self::refundOrder($request, $order);
                if (isset($checkout->http_code) and $checkout->http_code < 400){
                    $order->status = 'cancel';
                    $order->save();
                    return 'Your order was canceled without commissions !';
                }else{
                    throw new \Exception('You already refund this order !');
                }
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
