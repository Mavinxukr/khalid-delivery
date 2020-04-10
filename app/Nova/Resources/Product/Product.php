<?php

namespace App\Nova\Resources\Product;


use App\Nova\Actions\ImportProduct;
use App\Nova\Resource;
use App\Nova\Resources\Category\MenuCategory;
use App\Nova\Resources\Provider\Provider;
use Epartment\NovaDependencyContainer\HasDependencies;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use OwenMelbz\RadioField\RadioButton;
use Sloveniangooner\SearchableSelect\SearchableSelect;

class Product extends Resource
{
    use HasDependencies;
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
    public static $title = 'title';

    //public static $importer = MenuImport::class;


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','title','description'
    ];

    public static function label()
    {
        return 'Product';
    }

    public static $group = 'Product';

    public static $category = "Product";

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
            new Panel('Single add product', $this->SingleAddMenuFields($request)),
        ];
    }

    protected function SingleAddMenuFields(Request $request)
    {
        return [
            Number::make('Price','price')
                ->onlyOnIndex(),
            RadioButton::make('Provider type', 'type')
                ->options([
                    'food'          => 'Food',
                    'service'       => 'Service'
                ])
                ->hideFromDetail()
                ->hideFromIndex(),
            BelongsTo::make('Parent','parent',Product::class)
                ->exceptOnForms(),
            NovaDependencyContainer::make([
                Boolean::make('Has ingredients','has_ingredients')
                    ->trueValue(1)
                    ->falseValue(0)
                    ->exceptOnForms(),
                Number::make('Weight')
                    ->rules('required'),
                BelongsTo::make('Category','categories', MenuCategory::class)
                    ->searchable(),
                NovaDependencyContainer::make([
                    Number::make('Price for one','price')
                        ->exceptOnForms(),
                ])->dependsOn('has_ingredients',false),
            ])->dependsOn('type', 'food'),

            NovaDependencyContainer::make([
                Boolean::make('Has ingredients','has_ingredients')
                    ->trueValue(1)
                    ->falseValue(0)
                    ->exceptOnForms(),
                NovaDependencyContainer::make([
                    Number::make('Price for hour','price')
                        ->exceptOnForms(),
                    Text::make('Query', 'query')
                        ->rules(['required']),

                    Select::make('Answer Type', 'answer_type')
                        ->options([
                            'count' => 'count',
                            'boolean' => 'boolean',
                            'boolean&count' => 'boolean&count'
                        ])
                        ->rules(['required']),
                ])->dependsOn('has_ingredients',false),

            ])->dependsOn('type', 'service'),
            BelongsTo::make('Company','provider', Provider::class)
                ->searchable(),
            Text::make( 'Title','title')
                ->rules('required', 'max:100'),
            Text::make('Description','description')
                ->rules('required', 'max:300'),
            Image::make('Image')
                ->disk('public')
                ->path('image/product/')
                ->sortable()
                ->help("Upload image")
                ->rules( 'file'),
            Text::make('Type', 'type')
                ->exceptOnForms(),
            Boolean::make('Active')
                ->trueValue(1)
                ->falseValue(0)
                ->exceptOnForms(),
            HasMany::make('Component','component', Component::class)
                ->canSee(function (){
                    return
                        $this->type === 'food' && $this->has_ingredients ||
                        $this->type === 'service' && $this->has_ingredients;
                }),
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
        return [
           // new \Sparclex\NovaImportCard\NovaImportCard(Menu::class),
        ];
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
            new ImportProduct
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('type', '!=','ingredient');
    }
}
