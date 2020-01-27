<?php

namespace App\Providers;

use App\Contracts\Client\Auth\AuthInterface;
use App\Contracts\Client\Auth\AuthSocialInterface;
use App\Contracts\Client\Checkout\OrderCheckoutInterface;
use App\Contracts\Client\CreditCard\CreditCardInterface;
use App\Contracts\Client\Feedback\FeedbackInterface;
use App\Contracts\Client\Order\CartInterface;
use App\Contracts\Client\Order\OrderFoodInterface;
use App\Contracts\Client\Order\OrderServiceInterface;
use App\Contracts\Client\Place\PlaceInterface;
use App\Contracts\Client\Product\FilterInterface;
use App\Contracts\Client\Product\ProductInterface;
use App\Contracts\Client\Product\SingleProductInterface;
use App\Contracts\Client\Profile\ProfileInterface;
use App\Repositories\Client\AuthRepository;
use App\Repositories\Client\AuthSocialRepository;
use App\Repositories\Client\CartRepository;
use App\Repositories\Client\CreditCardRepository;
use App\Repositories\Client\FeedbackRepository;
use App\Repositories\Client\FilterRepository;
use App\Repositories\Client\OrderCheckoutRepository;
use App\Repositories\Client\OrderFoodRepository;
use App\Repositories\Client\OrderServiceRepository;
use App\Repositories\Client\PlaceRepository;
use App\Repositories\Client\ProductRepository;
use App\Repositories\Client\ProfileRepository;
use App\Repositories\Client\SingleProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProfileInterface::class,ProfileRepository::class);
        $this->app->bind(AuthInterface::class,AuthRepository::class);
        $this->app->bind(OrderServiceInterface::class,OrderServiceRepository::class);
        $this->app->bind(PlaceInterface::class,PlaceRepository::class);
        $this->app->bind( CreditCardInterface::class,CreditCardRepository::class);
        $this->app->bind( ProductInterface::class,ProductRepository::class);
        $this->app->bind( FeedbackInterface::class,FeedbackRepository::class);
        $this->app->bind( AuthSocialInterface::class,AuthSocialRepository::class);
        $this->app->bind(SingleProductInterface::class, SingleProductRepository::class);
        $this->app->bind(CartInterface::class, CartRepository::class);
        $this->app->bind(FilterInterface::class, FilterRepository::class);
        $this->app->bind(OrderFoodInterface::class,OrderFoodRepository::class);
    }
}
