<?php


namespace App\Nova\Resources\Order;


use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;

class CancelOrderItems extends Resource
{

    public static $model = 'App\Models\Order\CancelOrderItem';

    public static function label()
    {
        return 'Order Cancel Item';
    }

    public static $category = "Order";


    public static $group = 'Order';

    public function fields(Request $request)
    {
        return [
            Text::make('description'),
            Image::make('Image')
        ];

    }
}
