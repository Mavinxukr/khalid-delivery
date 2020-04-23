<?php


namespace App\Helpers;


use App\Models\Checkout\Checkout;
use App\Models\Order\Order;
use App\Models\Transactions\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Ixudra\Curl\Facades\Curl;
use Laravel\Nova\Actions\Action;

class TransactionHelper
{
    public static function getTransactions()
    {
        $end_day = Carbon::now()->format('Y-m-d');
        $start_day = Carbon::now()->subDays(59)->format('Y-m-d');
        $array = [
            '4001' => "Missing parameters",
            '4002' => "Invalid Credentials",
            '4003' => "Invalid \"enddate\" parameter, must be in YYYY-MM-DD format",
            '4091' => "No Data",
            '4006' => "Your time interval should be less than 60 days",
        ];
        $response = Curl::to('https://www.paytabs.com/expressv2/transaction_reports')
            ->withData([
                'merchant_id' => Config::get('app.merchant_id'),
                'secret_key'  => Config::get('app.secret_key'),
                'startdate'   => $start_day,
                'enddate'     => $end_day
            ])
            ->post();
        $result = json_decode($response);
        if($result->response_code != 4090){
            return $array[$result->response_code];
        }
        foreach ($result->details as $item){
            $item->transaction_datetime = Carbon::parse($item->transaction_datetime);
            $order = Order::find($item->order_id);
            if($order){
                $item->checkout_id = $order->checkout->id ?? null;
                Transaction::updateOrCreate((array)$item);
            }

        }
    }
}
