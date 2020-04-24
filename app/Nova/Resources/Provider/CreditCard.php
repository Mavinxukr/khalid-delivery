<?php

namespace App\Nova\Resources\Provider;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class CreditCard extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Provider\CompanyCreditCard';

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

            Text::make('holder_name')
                    ->rules('required', 'string', 'max:255'),

            Text::make('number_card')->withMeta([
                    'extraAttributes' => ['maxlength' => 16]
                ])
                ->rules('required','numeric'),

            Select::make('expire_month')
                ->options([
                    '01' => '01',
                    '02' => '02',
                    '03' => '03',
                    '04' => '04',
                    '05' => '05',
                    '06' => '06',
                    '07' => '07',
                    '08' => '08',
                    '09' => '09',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12'
                ])
                ->rules('required'),

            Text::make('expire_year')->withMeta([
                    'extraAttributes' => ['maxlength' => 4]
                ])
                ->rules('required','numeric'),

            Text::make('cvv_code')->withMeta([
                    'extraAttributes' => ['maxlength' => 3]
                ])
                ->rules('required','numeric'),

            Number::make('zip_code')
                ->rules('required','numeric'),

            BelongsTo::make('Company','provider',Provider::class)
                ->rules('required','unique:setting_providers,provider_id,'.$request->provider),

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
