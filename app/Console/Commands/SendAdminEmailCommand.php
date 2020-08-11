<?php

namespace App\Console\Commands;

use App\Models\Payment\Payment;
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
        $date = Carbon::now()->addDay(1)->format('Y-m-d');
        $payments = Payment::where('deadline', '=',  $date)->get();
        foreach ($payments as $payment){
            \Notification::route('mail', config('app.admin_mail'))
                ->notify( new AdminNotification($payment));
        }
    }
}
