<?php

namespace App\Nova\Actions;

use App\Models\Provider\Provider;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Date;

class PaymentForPeriod extends Action
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
        $provider =  $models->first()->provider_id;
        $company = Provider::find($provider)->name;
        if (isset($provider)) {
            $orders = $models->all();
            $count = 0;

            foreach ($orders as $order) {
                $array[] = $order->id;
                $count += $order->debt;
            }

            $invoice = \App\Models\Payment\CommissionInvoice::create([
                'name' => "Invoice of ".$company." for period",
                'count' => $count,
                'action' => 'increment',
                'provider_id' => $provider,
                'product_id' => $models->first()->product_id,
                'status' => 'pending',
                'deadline' => $fields->deadline
            ]);
            $invoice->orders()->attach($array);

        }else{
            return Action::danger('This order is still does not have a company');
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
            Date::make('Deadline')->rules('required'),
        ];
    }
}
