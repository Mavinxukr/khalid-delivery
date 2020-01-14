<?php

namespace App\Nova\Actions\Actions;

use App\Nova\Resources\Provider\Provider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;

class ConfirmOrder extends Action
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
        $order = $models->first();
        if ($order->provider_category === 'food'){
            return Action::danger('Can not confirm in type food !!!');
        }
        if ($order->status === 'new'){
            $order->provider_id = $fields->company;
            $order->status = 'confirm';
            $order->save();
        }else{
            return Action::danger('Accept an order possible only in status: new ');
        }


    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $companies = \App\Models\Provider\Provider::whereHas('categories',function ($item){
            $item->whereType('service');
        })->get()
          ->pluck('name','id');

        return [
            Select::make('Company')
                ->options($companies)
        ];
    }
}
