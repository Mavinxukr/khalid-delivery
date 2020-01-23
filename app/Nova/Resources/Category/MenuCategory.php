<?php

namespace App\Nova\Resources\Category;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class MenuCategory extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Category\ProductCategory';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */

    public static function label()
    {
        return 'Category menu';
    }

    public static $category = "Category";

    public static $group = 'Menu category';

    public static $title = 'type';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','type'
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
            Text::make('Type')
                ->sortable()
                ->rules('required', 'max:255'),
            Boolean::make('Active')
                ->trueValue(1)
                ->falseValue(0),
            Avatar::make('Image')
                ->prunable(true)
                ->disk('public')
                ->path('image/category-menu/')
                ->sortable()
                ->help("Upload image")
                ->rules( 'file'),
            Text::make('Cause')
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
