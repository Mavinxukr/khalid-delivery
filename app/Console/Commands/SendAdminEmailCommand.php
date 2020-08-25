<?php

namespace App\Console\Commands;

use App\Models\Payment\CommissionInvoice;
use App\Models\Payment\Payment;
use App\Models\Provider\Provider;
use App\Notifications\AdminNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAdminEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:email';

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
        $now = Carbon::now()->format('Y-m-d');
        $invoices = CommissionInvoice::whereId(3)->get();
        foreach ($invoices as $invoice){
            $end_date = Carbon::parse($invoice->deadline)->subDays($invoice->provider->days_before_invoice)->format('Y-m-d');
            if($end_date == $now){
                \Notification::route('mail', config('app.admin_mail'))
                    ->notify( new AdminNotification($invoice));
            }
        }
    }
}
