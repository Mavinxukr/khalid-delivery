<?php


namespace App\Repositories\Client;


use App\Contracts\Client\Checkout\OrderCheckoutInterface;
use App\Helpers\TransJsonResponse;
use Checkout\CheckoutApi;
use Checkout\Models\Payments\TokenSource;
use Illuminate\Http\Request;
use Checkout\Models\Payments\Payment;

class OrderCheckoutRepository implements OrderCheckoutInterface
{
    public function checkout(Request $request)
    {
        try {

            // Set the secret key
            $secretKey =   config('services.checkout_pay.sk_test_key');
            // Initialize the Checkout API
            $checkout = new CheckoutApi($secretKey);

            // Create a payment method instance with card details
            $method = new TokenSource($request->card_token);

            // Prepare the payment parameters
            $payment = new Payment($method, 'GBP');
            $payment->amount = 1000; // = 10.00


            // Send the request and retrieve the response
            $response = $checkout->payments()->request($payment);

            dd($response);


            return $response;
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false,null, $exception->getMessage(), 400);
        }

    }

    public function format($data)
    {
        // TODO: Implement format() method.
    }
}
