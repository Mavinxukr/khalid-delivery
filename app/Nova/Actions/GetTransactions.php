<?php

namespace App\Nova\Actions;

use App\Models\Order\Order;
use App\Models\Transactions\Transaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Ixudra\Curl\Facades\Curl;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Date;

class GetTransactions extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $array = [
            '4001' => "Missing parameters",
            '4002' => "Invalid Credentials",
            '4091' => "No Data",
            '4006' => "Your time interval should be less than 60 days",
        ];
        $response = Curl::to('https://www.paytabs.com/expressv2/transaction_reports')
            ->withData([
                'merchant_id' => Config::get('app.merchant_id'),
                'secret_key'  => Config::get('app.secret_key'),
                'startdate'   => $fields->start_day,
                'enddate'     => $fields->end_day
            ])
            ->post();
        $result = json_decode($response);
        if($result->response_code != 4090){
            return Action::danger($array[$result->response_code]);
        }
        foreach ($result->details as $item){
            $item->transaction_datetime = Carbon::parse($item->transaction_datetime);
            $order = Order::find($item->order_id);
            (!isset($order)) ?:
                Transaction::updateOrCreate((array)$item);
        }
//        $transactions = Transaction::whereBetween('transaction_datetime', [$fields->start_day, $fields->end_day])
//            ->get();
//        return $transactions;
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Date::make('Start Day','start_day'),
            Date::make('End Day','end_day'),
        ];
    }
}
