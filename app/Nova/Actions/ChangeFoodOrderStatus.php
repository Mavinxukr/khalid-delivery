<?php

namespace App\Nova\Actions\Actions;

use App\Helpers\PushHelper;
use App\Models\Order\OrderStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class ChangeFoodOrderStatus extends Action
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
        if ($order->provider_category === 'service'){
            return Action::danger('Can not confirm in type service !!!');
        }

        if($fields->status_id == 1 || $fields->status_id == 2){
            $order->status = 'new';
        }elseif ($fields->status_id == 3 || $fields->status_id == 4){
            $order->status = 'confirm';
        }elseif ($fields->status_id == 5){
            $order->status = 'done';
        }elseif ($fields->status_id == 6){
            $order->status = 'cancel';
        }

        $order->status_id = $fields->status_id;
        $order->save();

        PushHelper::sendPush($order->user_id, "Your order status changed to " . OrderStatus::findOrFail($fields->status_id)->name);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $statuses = OrderStatus::all()->pluck('name', 'id');

        return [
            Select::make('Status Id', 'status_id')
                ->options($statuses)
        ];
    }
}
