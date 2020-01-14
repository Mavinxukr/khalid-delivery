<?php

namespace App\Nova\Resources\Provider;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Tests\Fixtures\Tag;

class ProviderSetting extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Provider\SettingProvider';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $category = "Company";
    /**
     * The columns that should be searched.
     *
     * @var array
     */

    public static function label()
    {
        return 'Company setting';
    }
    public static $search = [
        'id',
    ];

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
            Text::make('Kitchen')
                ->nullable('required'),
            Text::make('Time Delivery Mean')
                ->nullable('required'),
            Text::make('Min order value','min_order')
                ->nullable('required'),
            Text::make('Delivery fee','delivery_fee')
                ->nullable('required'),
            Text::make('Schedule')
                ->nullable('required'),
            Text::make('Tags')
                ->nullable('required'),
            Number::make('Rating')
                ->nullable('required'),
            Number::make('Price rating')
                ->nullable('required'),
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
