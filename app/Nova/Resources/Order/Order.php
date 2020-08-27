<?php

namespace App\Nova\Resources\Order;

use App\Nova\Actions\Actions\ChangeFoodOrderStatus;
use App\Nova\Actions\Actions\ConfirmOrder;
use App\Nova\Actions\CommissionInvoice;
use App\Nova\Actions\PaymentForPeriod;
use App\Nova\Actions\PaymentOrder;
use App\Nova\Filters\Company;
use App\Nova\Filters\EndPeriod;
use App\Nova\Filters\RangePeriod;
use App\Nova\Filters\StartPeriod;
use App\Nova\Resource;
use App\Nova\Resources\Product\Product;
use App\Nova\Resources\Provider\Provider;
use App\Nova\Resources\User\User;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Michielfb\Time\Time;
use OwenMelbz\RadioField\RadioButton;
use Sloveniangooner\SearchableSelect\SearchableSelect;
use Timothyasp\Badge\Badge;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Order\Order';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name'
    ];

    public static function label()
    {
        return 'Order';
    }



    public static $category = "Order";


    public static $group = 'Order';

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
            BelongsTo::make('User','user',User::class)
                ->exceptOnForms(),
            Text::make('Paid')
                ->exceptOnForms(),
            Text::make('Debt')
                ->exceptOnForms(),
            RadioButton::make('Provider type', 'provider_category')
                ->options([
                    'food' => 'Food',
                    'service' => 'Service',
                ])
                ->hideFromDetail()
                ->hideFromIndex()
                ->exceptOnForms(),
            Text::make('Payment Type', 'payment_type')
                ->exceptOnForms(),
            Text::make('B2B1', 'b2b_1')
                ->exceptOnForms(),
            Text::make('B2B2', 'b2b_2')
                ->exceptOnForms(),
            Text::make('B2B3', 'b2b_3')
                ->exceptOnForms(),
            NovaDependencyContainer::make([
                Number::make('Quantity','quantity')
            ])->dependsOn('provider_category', 'food')->exceptOnForms(),
            NovaDependencyContainer::make([
                //Number::make('Count cleaning','count_clean'),
                Select::make('Type cleaning','type_cleaning')
                    ->options([
                        '1' => 'house',
                        '2' => 'office',
                        '3' => 'flat',
                    ]),
                //Number::make('Quantity hours','quantity'),
                Select::make('Callback Time')
                    ->options([
                        '10' => '10 min',
                        '15' => '15 min',
                        '30' => '30 min',
                        '60' => '60 min'
                    ])
                    ->hideFromIndex()
                    ->hideFromDetail(),
                /*Number::make('Interval')
                    ->withMeta([
                        'value' => 0
                    ]),*/
            ])->dependsOn('provider_category', 'service'),
            BelongsTo::make('Place','place',\App\Nova\Resources\Place\Place::class)
                ->exceptOnForms(),
            Select::make('Status')
                ->options([
                    'new'       => 'new',
                    'confirm'   => 'confirm',
                    'cancel'    => 'cancel',
                    'done'      => 'done'
                ])
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating(),
            Text::make('debt')
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating(),
            Text::make('cost')
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating(),
            Text::make('initial_cost')
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating(),
            Text::make('service_received')
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating(),
            Text::make('company_received')
                ->hideFromIndex()
                ->hideFromDetail()
                ->hideWhenCreating(),
            BelongsTo::make('Accept company','provider', Provider::class)
                ->exceptOnForms(),
            Text::make('Provider category','provider_category')
                ->exceptOnForms(),
            Badge::make('Status')
                ->colors([
                    'wait'      => 'brown',
                    'new'       => 'red',
                    'confirm'   => 'green',
                    'cancel'    => 'peru',
                    'done'      => 'aqua'
                ])
                ->exceptOnForms(),
            Text::make('Name')
                ->rules('required')
                ->exceptOnForms(),
                 SearchableSelect::make('Product name','product_id')
                     ->resource(Product::class)
                     ->help("Need chose provider")
                     ->rules('required')
                     ->hideFromIndex()
                     ->hideWhenUpdating()
                     ->hideFromDetail(),
            Date::make('Date','date_delivery')
                ->format('YYYY-MM-DD')
                ->rules('required')
                ->exceptOnForms(),
            Time::make('Time From','date_delivery_from')
                ->format('HH:mm:ss')
                ->rules('required')
                ->exceptOnForms(),
            Time::make('Time To','date_delivery_to')
                ->format('HH:mm:ss')
                ->rules('required')
                ->exceptOnForms(),
            Textarea::make('Comment')
                ->exceptOnForms(),
            Number::make('Cost')
                ->exceptOnForms(),
            Number::make('Service received', 'service_received')
                ->exceptOnForms(),
            Number::make('Company received', 'company_received')
                ->exceptOnForms(),
            BelongsToMany::make('Product','products', Product::class)
                ->canSee(function (){
                    return $this->provider_category === 'food';
                })
                ->fields(function () {
                    return [
                        Boolean::make('Canceled', 'canceled')
                            ->displayUsing(function ($field, $resource) {
                                return isset($this->pivot) ? $this->pivot->canceled : '-';
                            }),
                    ];
                })
                ->exceptOnForms(),

            HasOne::make('Answers', 'answers', OrderDetail::class)
                ->exceptOnForms(),

            HasOne::make('Checkout', 'checkout', Checkouts::class)
                ->exceptOnForms(),
            HasMany::make('Checks', 'checks', OrderCheck::class),
        ];
    }

    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return 'resources/orders';
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
            (new Company),
            (new StartPeriod),
            (new EndPeriod),
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
        return [
            new PaymentOrder,
            new PaymentForPeriod,
            new CommissionInvoice,
            (new ConfirmOrder)
                ->onlyOnTableRow(),
            (new ChangeFoodOrderStatus)
                ->onlyOnTableRow(),
        ];
    }
}
