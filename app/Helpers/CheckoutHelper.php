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
    public static function checkoutOrder(Request $request, Order $order)
    {
        try {
            $secretKey =   config('services.checkout_pay.sk_test_key');
            $checkout = new CheckoutApi($secretKey);
            $method = new TokenSource($request->card_token);
            $payment = new Payment($method, 'AED');
            $payment->amount = $order->cost * 100;
            $response = $checkout->payments()->request($payment);
            return $response;
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false,null, $exception->getMessage(), 400);
        }
    }

    public static function addToCheckout ($checkout, Request $request, Order $order)
    {
         Checkout::create([
            'card_token'            => $request->card_token,
            'source_id'             => $checkout->source['id'],
            'source_type'           => $checkout->source['type'],
            'source_card_type'      => $checkout->source['card_type'],
            'source_scheme'         => $checkout->source['scheme'],
            'source_card_category'  => $checkout->source['card_category'],
            'source_issuer'         => $checkout->source['issuer'],
            'source_issuer_country' => $checkout->source['issuer_country'],
            'checkout_id'           => $checkout->id,
            'checkout_action_id'    => $checkout->action_id,
            'status'                => $checkout->response_summary,
            'sum'                   => $order->cost ,
            'currency'              => $checkout->currency,
            'user_id'               => $request->user()->id,
            'order_id'              => $order->id
        ]);

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
