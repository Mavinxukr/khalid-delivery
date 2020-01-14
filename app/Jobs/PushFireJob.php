<?php

namespace App\Jobs;

use App\Models\Feedback\FirePush;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PushFireJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $push;

    public function __construct(FirePush $push)
    {
        $this->push = $push;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //here will be send push to ios and android
        \Log::info('to: - '. $this->push->user->email. ' time:- '. Carbon::now());
    }
}
