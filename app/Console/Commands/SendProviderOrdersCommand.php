<?php

namespace App\Console\Commands;

use App\Models\Order\Order;
use App\Models\Provider\Provider;
use App\Notifications\SendNotification;
use Illuminate\Console\Command;
use Illuminate\Notifications\Messages\MailMessage;

class SendProviderOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orders = Order::where('status', 'done')
            ->where('debt', '>', 0)
            ->pluck('provider_id')
            ->toArray();
        $providers = Provider::whereIn('id', array_unique($orders))->get();
        foreach ($providers as $provider){
            $prov_orders = Order::where([
                    'status' => 'done',
                    'provider_id' => $provider->id,
                ])
                ->where('debt', '>', 0)
                ->get();
            if(count($prov_orders) > 0){
                $provider->notify(new SendNotification((new MailMessage)
                    ->view('tax.orders', [
                        'orders'    => $prov_orders,
                        'provider'  => $provider,
                    ])));
            }
        }
    }
}
