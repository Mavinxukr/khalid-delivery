<?php

namespace App\Nova\Actions;

use App\Notifications\CheckNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class SendNotification extends Action
{
    use InteractsWithQueue, Queueable;


    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $model
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $model)
    {

        $instance = $model->first();
        if($instance->checks->count()){
            $instance->user->notify(new CheckNotification($instance, $instance->user));
        }else{
            return Action::danger('Please, upload check !!!');
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
