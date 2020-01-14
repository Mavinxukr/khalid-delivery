<?php


namespace App\Providers;

use App\Interfaces\Company\Auth\AuthInterface;
use App\Interfaces\Company\Profile\ProfileInterface;
use App\Repositories\Company\AuthRepository;
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

    }
}

