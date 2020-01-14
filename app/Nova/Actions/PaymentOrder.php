<?php

namespace App\Nova\Actions;

use App\Models\Payment\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use OwenMelbz\RadioField\RadioButton;


class PaymentOrder extends Action
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
        if (isset($provider)) {
            $orders = $models->all();
            $count = 0;

            foreach ($orders as $order) {

                if ($order->debt > 0) {
                    if ($fields->count <= $order->debt) {
                        $count = $fields->count;
                    }
                    if ($fields->count > $order->debt) {
                        $count = $order->debt;
                    }

                    $cond = Payment::whereOrderId($order->id)->sum('count');


                    if ($order->cost > $cond) {
                        if ($cond + $count > $order->cost) {
                            $count = $order->cost - $cond;
                        }

                        \App\Models\Payment\Payment::create([
                            'name' => $fields->name,
                            'count' => $count,
                            'action' => 'increment',
                            'provider_id' => $provider,
                            'product_id' => $models->first()->product_id,
                            'status' => 'pending',
                            'order_id' => $order->id
                        ]);
                        $order->save();
                    }
                }
            }
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
            Text::make('Name')
                ->rules('required'),
            Number::make('Count')
                ->rules('required'),
        ];
    }
}
