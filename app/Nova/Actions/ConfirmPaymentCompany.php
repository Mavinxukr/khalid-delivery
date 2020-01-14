<?php

namespace App\Nova\Actions;

use App\Nova\Resources\Provider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Number;

class ConfirmPaymentCompany extends Action
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
       $pay = $models->first();
       if ($pay->status =='processing') {
           if ($models->first()->action == 'increment') {
               \App\Models\Payment\Payment::where('id', $models->first()->id)
                   ->update([
                       'count' => $fields->count
                   ]);
               \App\Models\Provider\Provider::where('id', $models->first()->provider_id)
                   ->increment('balance', $fields->count);
           }
           if ($models->first()->action == 'decrement') {
               \App\Models\Payment\Payment::where('id', $models->first()->id)
                   ->update([
                       'count' => $fields->count
                   ]);
               \App\Models\Provider\Provider::where('id', $models->first()->provider_id)
                   ->decrement('balance', $fields->count);
           }
           $pay->status = 'approved';
           $pay->save();

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
            Number::make('Count','count')
        ];
    }
}
