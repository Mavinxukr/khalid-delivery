<?php

namespace App\Nova\Resources\Place;

use App\Nova\Resource;
use App\Nova\Resources\User\User;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields;

class Place extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\PlaceService\Place';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static $category = "Place";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name','address'
    ];

    public static function label()
    {
        return 'Place';
    }


    public static $group = 'Place';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $user = \App\User::all()
                ->pluck('name','id');
        return [
            ID::make()->sortable(),
            Text::make('Name')
                ->rules('required'),
            $this->addressFields(),
            Fields\BelongsTo::make('User','user',User::class)
        ];
    }

    protected function addressFields()
    {
        return $this->merge([
            Fields\Place::make('Address')
                ->countries(['UA']),
            Text::make('City')
                ->hideFromIndex(),
            Text::make('Postal Code')
                ->hideFromIndex(),
            Fields\Country::make('Country')
                ->hideFromIndex(),
            Text::make('Latitude')
                ->hideFromIndex(),
            Text::make('Longitude')
                ->hideFromIndex(),
        ]);
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
