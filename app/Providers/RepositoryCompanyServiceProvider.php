<?php


namespace App\Providers;

use App\Contracts\Company\Auth\AuthInterface;
use App\Contracts\Company\Feedback\FeedbackInterface;
use App\Contracts\Company\Profile\ProfileInterface;
use App\Contracts\Company\Service\CompanyServiceInterface;
use App\Repositories\Company\AuthRepository;
use App\Repositories\Company\CompanyServiceRepository;
use App\Repositories\Company\FeedbackRepository;
use App\Repositories\Company\ProfileRepository;
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

    }
}

