<?php

namespace App\Nova\Resources\Order;

use App\Nova\Resource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaGoogleMaps\GoogleMaps;

class OrderExtend extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Order\OrderExtend';

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

    public static function label()
    {
        return 'Orders Extends';
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
            BelongsTo::make('Order', 'order'),
            Text::make('Extend From', 'extend_from'),
            Text::make('Extend To', 'extend_to'),
            Text::make('Reason', 'reason'),
            Text::make('Initial Cost', 'initial_cost'),
            Text::make('Cost', 'cost'),
            Text::make('Service Received', 'service_received'),
            Text::make('Company Received', 'company_received'),
            Text::make('Accepted', 'accepted'),
            HasMany::make('Files', 'files', OrderExtendFile::class)
                ->onlyOnDetail(),
            GoogleMaps::make('Map')
                ->zoom(17) // Optionally set the zoom level
                ->defaultCoordinates(50.8466, 4.3517)
                ->showOnDetail(),
            DateTime::make('Completed at', 'completed_at'),
            Text::make('Located there')->exceptOnForms()
                ->displayUsing(function (){
                    $fromH = Carbon::make($this->extend_from)->hour;
                    $fromM = Carbon::make($this->extend_from)->minute;
                    $toH = Carbon::make($this->extend_to)->hour;
                    $toM = Carbon::make($this->extend_to)->minute;
                    $hours = $toH - $fromH ;
                    $minutes = $toM - $fromM;
                    $text = '';
                    if ($hours > 0){
                        $hours .= ' hours';
                        $text .= $hours;
                    }
                    if ($minutes > 0){
                        $minutes .= ' minutes';
                        $text .= ' '.$minutes;
                    }
                    return $text;
            })
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
        return [];
    }

}
