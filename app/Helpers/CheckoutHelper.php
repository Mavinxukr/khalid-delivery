<?php


namespace App\Helpers;


use App\Models\Checkout\Checkout;
use App\Models\Order\Order;
use Checkout\CheckoutApi;
use Checkout\Models\Payments\Payment;
use Checkout\Models\Payments\Refund;
use Checkout\Models\Payments\TokenSource;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

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
       return $request->status <= 100 ? true : false;
    }

    public static function refundOrder(Request $request, Order $order)
    {
        $userOrder = $request->user()
                                ->order()
                                ->findOrFail($order->id);
        $orderCheckout = $userOrder->checkout;
        try {
            $response = Curl::to('https://www.paytabs.com/apiv2/refund_process')
                            ->withData([
                                'merchant_email' => 'khalid@appadminportal.com',
                                'secret_key'     => 'hptS4rVoHq1hlGyOETImUGBCW60PuakLzOEDgz1YZ3flJO9oHSKCymeusejXoEIXsmBJVCHVGXgqLpOtiz5QVjkoxElWj4UMrvvn',
                                'refund_amount'  => $orderCheckout->sum,
                                'refund_reason'  => 'Cancel order',
                                'transaction_id' => $orderCheckout->transaction_id,
                                'order_id'       => $userOrder->id
                            ])
                            ->asJson()
                            ->post();

            $orderCheckout->status = 'Refunded';
           // $orderCheckout->message = 'Refunded';
            $orderCheckout->save();
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false,null, $exception->getMessage(), 400);
        }
    }



}
