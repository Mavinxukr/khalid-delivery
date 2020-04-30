<?php

namespace App\Nova\Actions;

use App\Models\Payment\Payment;
use App\Notifications\SendNotification;
use App\Nova\Resources\Provider\Provider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use OwenMelbz\RadioField\RadioButton;
use Sloveniangooner\SearchableSelect\SearchableSelect;


class CommissionInvoice extends Action
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
        $provider =  $models->first()->provider;
        $provider->notify(new SendNotification((new MailMessage)
            ->view('tax.invoice', [
                'orders'     => $models,
                'provider'  => $provider,
            ])));
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
