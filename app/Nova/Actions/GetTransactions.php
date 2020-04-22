<?php

namespace App\Nova\Actions;

use App\Models\Transactions\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
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
            '4091' => "No Data"
        ];
        $response = Curl::to('https://www.paytabs.com/expressv2/transaction_reports')
            ->withData([
                'merchant_id' => 10053283,
                'secret_key'  => 'hptS4rVoHq1hlGyOETImUGBCW60PuakLzOEDgz1YZ3flJO9oHSKCymeusejXoEIXsmBJVCHVGXgqLpOtiz5QVjkoxElWj4UMrvvn',
                'startdate'   => $fields->start_day,
                'enddate'     => $fields->end_day
            ])
            ->post();
        $result = json_decode($response);
        if($result->response_code != 4090){
            return Action::danger($array[$result->response_code]);
        }
        foreach ($result->details as $item){
            Transaction::updateOrCreate((array)$item);
        }
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
