<?php

namespace App\Nova\Resources\Message;

use App\Nova\Resource;
use App\Nova\Resources\Provider\Provider;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class SmsToUser extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Message\SmsToUser';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $category = "Message";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','body'
    ];

    public static function label()
    {
        return 'Log Message';
    }

    public static $group = 'Log Message';

    public static function authorizable()
    {
        return true;
    }


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
            Text::make('body')
                ->exceptOnForms(),
            BelongsTo::make('Provider','provider', Provider::class)
                ->exceptOnForms(),
            Text::make('Status')
                ->exceptOnForms(),
            Textarea::make('Log')
                ->exceptOnForms()
                ->hideFromIndex()

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
