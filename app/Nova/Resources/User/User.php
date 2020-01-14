<?php

namespace App\Nova\Resources\User;

use App\Nova\Resource;
use App\Nova\Resources\Provider\Provider;
use Defuse\Crypto\File;
use Dniccum\PhoneNumber\PhoneNumber;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;

class User extends Resource
{
    /**
     * The model the resource corresponds to
     *
     * @var string
     */
    public static $model = 'App\User';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'first_name';

    public static $category = "User";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'first_name', 'email',
    ];

    public static function label()
    {
        return 'Users';
    }

    public static $group = 'Users';

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
            Text::make('First name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Last name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),
            PhoneNumber::make('Phone')
                ->format('+380-##-##-##-###')
                ->placeholder('Example: 12-34-56-789')
                ->disableValidation()
                ->useMaskPlaceholder()
                ->linkOnIndex()
                ->linkOnDetail()
                ->rules('required'),
            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
            Boolean::make('Active')
                ->trueValue(1)
                ->falseValue(0),
            Avatar::make('Image')
                ->prunable(true)
                ->disk('public')
                ->path('image/profile/')
                ->sortable()
                ->help("Upload image")
                ->rules( 'file'),
            MorphToMany::make('Roles', 'roles', \Eminiarts\NovaPermissions\Nova\Role::class),
            MorphToMany::make('Permissions', 'permissions', \Eminiarts\NovaPermissions\Nova\Permission::class),
            \Laravel\Nova\Fields\BelongsTo::make('Company','company', Provider::class)
                ->nullable()
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
        ];
    }
}
