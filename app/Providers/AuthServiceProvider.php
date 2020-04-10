<?php

namespace App\Providers;

use App\Models\Fee\Fee;
use App\Models\Message\SmsToUser;
use App\Models\Order\Order;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        SmsToUser::class => 'App\Policies\LogPolicy',
        Order::class => 'App\Policies\OrderPolicy',
        Fee::class => 'App\Policies\FeePolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        //
    }
}
