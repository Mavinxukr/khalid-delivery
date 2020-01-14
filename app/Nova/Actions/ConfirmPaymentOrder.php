<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ConfirmPaymentOrder extends Action
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
        $queries = $models->all();

        foreach ($queries as $query ) {

            if ($query->status == 'pending') {
                $order = $query->order;
                    $company = $query->provider;
                    $company->balance += $query->count;
                    $order->paid += $query->count;
                    $order->debt = $order->cost - $order->paid;
                    $query->status = 'approved';
                    $query->save();
                    $company->save();
                    $order->save();

            }
        }

    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
