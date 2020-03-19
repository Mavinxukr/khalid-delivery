<?php


namespace App\Helpers;


use App\Models\Checkout\Checkout;
use App\Models\Order\Order;
use Checkout\CheckoutApi;
use Checkout\Models\Payments\Payment;
use Checkout\Models\Payments\Refund;
use Checkout\Models\Payments\TokenSource;
use Illuminate\Http\Request;

class CheckoutHelper
{
    public static function checkoutOrder(Request $request, Order $order) : bool
    {
       Checkout::updateOrCreate(
           ['user_id'   => $request->user()->id,
            'order_id'  => $order->id
           ],[
           'status'     => $request->status,
           'sum'        => $order->cost,
           'message'    => $request->message,
           'user_id'    => $request->user()->id,
           'order_id'   => $order->id,
           'transaction_id' => $request->transaction_id
       ]);
       return $request->status < 200 ? true : false;
    }

    public static function refundOrder(Request $request, Order $order)
    {
        $userOrder = $request->user()
                                ->order()
                                ->findOrFail($order->id);
        $orderCheckout = $userOrder->checkout;
        try {
            $secretKey =   config('services.checkout_pay.sk_test_key');
            $checkout = new CheckoutApi($secretKey);
            $refund = new Refund($userOrder->checkout->checkout_id);
            $refundOrder = $checkout->payments()->refund($refund);
            $orderCheckout->status = 'Refunded';
            $orderCheckout->checkout_action_id = $refundOrder->action_id;
            $orderCheckout->save();
            return $refundOrder;
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false,null, $exception->getMessage(), 400);
        }
    }



}
