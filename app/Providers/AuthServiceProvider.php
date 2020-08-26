<?php

namespace App\Providers;

use App\Models\Fee\Fee;
use App\Models\Invoice\InvoiceTemplate;
use App\Models\Message\SmsToUser;
use App\Models\Order\Order;
use App\Models\Order\OrderDetail;
use App\Models\Order\OrderExtend;
use App\Models\Order\OrderExtendFile;
use App\Models\Order\PreOrder;
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
        PreOrder::class => 'App\Policies\PreOrderPolicy',
        OrderDetail::class => 'App\Policies\OrderDetailPolicy',
        InvoiceTemplate::class => 'App\Policies\InvoiceTemplatePolicy',
        OrderExtend::class => 'App\Policies\OrderExtendPolicy',
        OrderExtendFile::class => 'App\Policies\OrderExtendFilePolicy',
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
