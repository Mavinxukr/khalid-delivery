<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Dashboard;

class AnalyticDashboard extends Dashboard
{

    public static function label()
    {
        return 'Analytic Dashboard';
    }
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new \App\Nova\Metrics\Order,
            new \App\Nova\Metrics\OrderSum
        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'analytic-dashboard';
    }
}
