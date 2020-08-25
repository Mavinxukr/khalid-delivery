<?php

namespace App\Providers;

use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Provider\Provider;
use App\Models\Provider\SettingProvider;
use App\Observers\CompanySettingObserver;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Observers\UpdateDeliveryTime;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(ProductObserver::class);
        SettingProvider::observe(CompanySettingObserver::class);
        Order::observe(OrderObserver::class);
        Provider::observe(UpdateDeliveryTime::class);
    }
}
