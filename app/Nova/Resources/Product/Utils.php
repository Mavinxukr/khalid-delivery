<?php


namespace App\Nova\Resources\Product;


use App\Nova\Resource;
use Epartment\NovaDependencyContainer\HasDependencies;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Utils extends Resource
{

    use HasDependencies;

    public static $model = 'App\Models\Util\Util';
    public static $group = 'Utils';
    public static $category = "Utils";
    public static $title = 'name';

    public static $search = [
        'id','name'
    ];

    public static function label()
    {
        return 'Utils';
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('name')
        ];
    }
}
