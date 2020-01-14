<?php


namespace App\Providers;

use App\Interfaces\Company\Auth\AuthInterface;
use App\Repositories\Company\AuthRepository;
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

    }
}

