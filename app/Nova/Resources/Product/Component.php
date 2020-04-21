<?php

namespace App\Nova\Resources\Product;

use App\Helpers\ImageLinker;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Component extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Product\Product';

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

    public static $category = "Product";
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $type = null;
        if(!is_null($request->viaResourceId))
            $type = \App\Models\Product\Product::findOrFail($request->viaResourceId)->type;

        return [
            ID::make()->sortable(),
            Text::make( 'Title','title')
                ->rules('required', 'max:100'),
            Text::make('Description','description')
                ->rules('required', 'max:300'),
            Number::make('Price')
                ->rules('required'),

            Text::make('Query', 'query')
                ->rules(['required'])
                ->canSee(function () use ($type){
                        return !is_null($type) && $type == 'service' || $this->query;
                })->hideFromIndex(),

            Select::make('Answer Type', 'answer_type')
                ->options([
                    'count' => 'count',
                    'boolean' => 'boolean',
                    'boolean&count' => 'boolean&count'
                ])
                ->rules(['required'])
                ->canSee(function () use ($type){
                    return !is_null($type) && $type == 'service' || $this->answer_type;
                })->hideFromIndex(),

            Image::make('Image')
                ->disk('public')
                ->path('image/product/')
                ->sortable()
                ->help("Upload image")
                ->preview(function ($value, $disk) {
                    return ImageLinker::linker($value);
                })
                ->thumbnail(function ($value, $disk) {
                    return ImageLinker::linker($value);
                })
                ->rules( 'file'),
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

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('type', 'ingredient');
    }

    public static function availableForNavigation(Request $request)
    {
        return false;
    }
}
