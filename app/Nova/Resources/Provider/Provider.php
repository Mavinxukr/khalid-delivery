<?php

namespace App\Nova\Resources\Provider;

use App\Helpers\ImageLinker;
use App\Nova\Actions\SendToNumber;
use App\Nova\Resources\Category\Category;
use App\Nova\Resources\User\User;
use Benjacho\BelongsToManyField\BelongsToManyField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Dniccum\PhoneNumber\PhoneNumber;
use Sloveniangooner\SearchableSelect\SearchableSelect;


class Provider extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Provider\Provider';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static function label()
    {
        return 'Company';
    }

    public static $group = 'Provider';

    public static $category = "Company";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name','description'
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
            Text::make('Name')
                ->sortable(),
            PhoneNumber::make('Phone Number')
                ->format('+380-##-##-##-###')
                ->placeholder('Example: 12-34-56-789')
                ->disableValidation()
                ->useMaskPlaceholder()
                ->linkOnIndex()
                ->linkOnDetail(),
            Text::make('Website')
                ->sortable(),
            Text::make('Email')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Street Address', 'street_address')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('City')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('State')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Country')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Zip')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Description')
                ->sortable(),
            SearchableSelect::make('Provider type','category_id')
                ->resource(Category::class)
                ->help("Need chose category")
                ->rules('required')
                ->hideFromIndex()
                ->hideFromDetail(),
            BelongsTo::make('Category','categories', Category::class)
                ->exceptOnForms(),
            Text::make('Chamber of commerce'),
            Boolean::make('Active')
                ->trueValue(1)
                ->falseValue(0)
                ->hideWhenCreating(),
            Number::make('balance')
                ->hideWhenCreating()
                ->hideWhenUpdating(),
            Number::make('Fee','count', function ($value) use($request){
                if ($request->editing){
                    return $value;
                }else{
                        return "$value%";
                }
            })
                ->rules('required'),
            Boolean::make('Charge')
                ->trueValue(1)
                ->falseValue(0),
            Image::make('Image','image')
                ->disk('public')
                ->path('image/provider')
                ->preview(function ($value, $disk) {
                    return ImageLinker::linker($value);
                })
                ->thumbnail(function ($value, $disk) {
                    return ImageLinker::linker($value);
                })
                ->rules('file')
                ->prunable(),
            HasOne::make('Provider setting','providerSetting',ProviderSetting::class),
            HasOne::make('Provider schedule','schedule',Schedule::class),
            BelongsToMany::make('Language','languages',Language::class),
            HasMany::make('Users','users',User::class),
            HasOne::make('Credit card','creditCard',CreditCard::class)

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
            new SendToNumber
        ];
    }
}
