<?php

namespace App\Console\Commands;

use App\Jobs\PushFireJob;
use App\Models\Feedback\FirePush;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PushFireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:fire';
    private $push;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send push to feedback';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FirePush $push)
    {
        $this->push = $push;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $nowFire = Carbon::now()->toDateString();

        $pushes =  $this->push->where('date',$nowFire)
                       ->get();
        foreach ($pushes as $push){
            if ($push->date == Carbon::now()->toDateTimeString()){
                $push->status = 'sent';
                $push->save();
                PushFireJob::dispatch($push);
            }
        }
    }
}
