<?php


namespace App\Providers;

use App\Contracts\Company\Auth\AuthInterface;
use App\Contracts\Company\Feedback\FeedbackInterface;
use App\Contracts\Company\Order\ActionServiceOrderInterface;
use App\Contracts\Company\Order\FoodOrderInterface;
use App\Contracts\Company\Order\ServiceOrderInterface;
use App\Contracts\Company\Place\PlaceInterface;
use App\Contracts\Company\Profile\ProfileInterface;
use App\Contracts\Company\Service\CompanyServiceInterface;
use App\Repositories\Company\ActionServiceOrderRepository;
use App\Repositories\Company\AuthRepository;
use App\Repositories\Company\CompanyServiceRepository;
use App\Repositories\Company\FeedbackRepository;
use App\Repositories\Company\FoodOrderRepository;
use App\Repositories\Company\PlaceRepository;
use App\Repositories\Company\ProfileRepository;
use App\Repositories\Company\ServiceOrderRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryCompanyServiceProvider extends ServiceProvider
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
        $this->app->bind(AuthInterface::class,AuthRepository::class);
        $this->app->bind(ProfileInterface::class, ProfileRepository::class);
        $this->app->bind(FeedbackInterface::class, FeedbackRepository::class);
        $this->app->bind(CompanyServiceInterface::class, CompanyServiceRepository::class);
        $this->app->bind(PlaceInterface::class, PlaceRepository::class);
        $this->app->bind(ServiceOrderInterface::class, ServiceOrderRepository::class);
        $this->app->bind(ActionServiceOrderInterface::class, ActionServiceOrderRepository::class);
        $this->app->bind(FoodOrderInterface::class, FoodOrderRepository::class);

    }
}

