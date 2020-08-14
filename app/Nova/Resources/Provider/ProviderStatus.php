<?php


namespace App\Nova\Resources\Provider;


use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class ProviderStatus extends Resource
{

    public static $model = 'App\Models\Provider\ProviderStatus';

    public static $title = 'title';

    public static function label()
    {
        return 'Provider status';
    }

    public static $group = 'Provider status';

    public static $category = "Company";

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')
                ->sortable(),
        ];
    }
}
