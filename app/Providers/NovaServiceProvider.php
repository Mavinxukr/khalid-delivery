<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */


    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }


    public function tools()
    {
        return [
            new \Beyondcode\TinkerTool\Tinker(),
            new \KABBOUCHI\LogsTool\LogsTool(),
            new \Eminiarts\NovaPermissions\NovaPermissions(),
        ];
    }


    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    public function card()
    {
        return [
            new \App\Nova\Metrics\Order,
            new \App\Nova\Metrics\OrderSum
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\AnalyticDashboard
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
