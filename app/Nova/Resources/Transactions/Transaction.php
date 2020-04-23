<?php

namespace App\Nova\Resources\Transactions;

use App\Nova\Actions\GetTransactions;
use App\Nova\Filters\EndDate;
use App\Nova\Filters\PeriodTransaction;
use App\Nova\Filters\StartDate;
use App\Nova\Resource;
use App\Nova\Resources\Order\Order;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Timothyasp\Badge\Badge;

class Transaction extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Transactions\Transaction';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'transaction_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];


    public static $category = "Transactions";


    public static $group = 'Transactions';
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Number::make('Transaction', 'transaction_id')
                ->sortable(),

            BelongsTo::make('Order', 'order', Order::class),

            Text::make('Customer Name', 'transaction_title')
                ->sortable(),

            Number::make('Amount')
                ->sortable(),

            Text::make('Currency')
                ->sortable(),

            Text::make('Time', 'transaction_datetime')
                ->sortable(),

            Badge::make('Status')
                ->colors([
                    'Payment Rejected' => 'red',
                    'Payment Approved' => 'green',
                ])
                ->exceptOnForms(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new StartDate(),
            new EndDate(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
