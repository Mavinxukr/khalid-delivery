<?php

namespace App\Nova\Actions;

use App\Nova\Resources\Message\SmsToUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Twilio\Rest\Client;
class SendToNumber extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_TOKEN');
        $client = new Client($sid, $token);

        foreach ($models->chunk(1) as $item){
            foreach ($item as $number){
                try {
                    $client->messages->create(
                        $number->phone_number,
                        [
                            'from' => env('TWILIO_FROM'),
                            'body' => $fields->body,
                        ]
                    );
                    \App\Models\Message\SmsToUser::create([
                        'body'          => $fields->body,
                        'provider_id'   => $number->id,
                        'status'        => 'success'
                    ]);
                }catch (\Exception $exception){
                    \App\Models\Message\SmsToUser::create([
                        'body'          => $fields->body,
                        'provider_id'   => $number->id,
                        'status'        => 'error' ,
                        'log'           =>  $exception->getMessage()
                    ]);
                }
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
        return [
            Text::make('Body message','body')
                ->rules('required')
        ];
    }
}
