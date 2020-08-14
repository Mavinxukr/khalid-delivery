<?php

namespace App\Nova\Resources\Payment;

use App\Nova\Actions\ConfirmPaymentOrder;
use App\Nova\Actions\ConfirmPaymentCompany;
use App\Nova\Resource;
use App\Nova\Resources\Order\Order;
use App\Nova\Resources\Product\Product;
use App\Nova\Resources\Provider\Provider;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Sloveniangooner\SearchableSelect\SearchableSelect;
use OwenMelbz\RadioField\RadioButton;
use Timothyasp\Badge\Badge;

class PaymentCompany extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Payment\Payment';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = 'Payment';


    public static $category = "Payment";

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
            Text::make('Name','name'),
            Date::make('Deadline'),
            SearchableSelect::make('Company name','provider_id')
                ->resource(Provider::class)
                ->help("Need chose provider")
                ->rules('required')
                ->hideFromIndex()
                ->hideWhenUpdating()
                ->hideFromDetail(),
            Badge::make('Type')
                ->colors([
                    'output'  => 'LightSeaGreen',
                    'input'   => 'gold'
                ])
                ->exceptOnForms(),
            Text::make('Status')
                ->exceptOnForms(),
            BelongsTo::make('Company','provider', Provider::class)
                ->exceptOnForms(),
            BelongsTo::make('Product','product', Product::class)
                ->exceptOnForms(),
            BelongsTo::make('Order','order', Order::class)
                ->exceptOnForms(),
            RadioButton::make('Action')
                ->options([
                    'increment' => 'Increment',
                    'decrement' => 'Decrement',
                ]) ->hideWhenUpdating(),
            Number::make('Count','count')
            ->exceptOnForms()

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
        return [];
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
        return [
            new ConfirmPaymentCompany,
            new ConfirmPaymentOrder
        ];
    }
}
