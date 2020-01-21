<?php


namespace App\Repositories\Client;


use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Order\CartInterface;
use App\Contracts\FormatInterface;
use App\Models\Order\Cart;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class CartRepository implements CartInterface, FormatInterface
{
    public function index($data)
    {
        $result = $data->user()
                        ->curt
                        ->map(function ($item){
                            return $this->format($item);
                        });
        return TransJsonResponse::toJson(true,$result,'Products in curt',200);
    }

    public function store($data)
    {
       $product = Product::findOrFail($data->product_id);

       if ($product->type !== 'service') {
           Cart::updateOrCreate([
               'user_id' => $data->user()->id,
               'product_id' => $data->product_id
           ],
               $data->all() +
               ['user_id' => $data->user()->id]
           );
           return TransJsonResponse::toJson(true, null, 'Successfully add to cart', 201);
       }else{
           return TransJsonResponse::toJson(false, null,
                                            'Product with type - service,can not be add to the cart', 400);
       }

    }

    public function update(Request $request, int $id)
    {
        $cart =  Cart::findOrFail($id);
        if ($request->has('quantity') && $request->quantity > 0){
            $cart->update([
                'quantity'  => $request->quantity
            ]);
        }else{
            $cart->delete();
        }
        return TransJsonResponse::toJson(true,null,'Successfully update', 200);
    }

    public function delete(int $id)
    {
        Cart::findOrFail($id)->delete();
        return TransJsonResponse::toJson(true,null,'Successfully delete', 200);
    }
    public function format($data)
    {
        return [
            'id'         => $data->id,
            'name'       => $data->product->title,
            'price'      => $data->product->price,
            'quantity'   => $data->quantity
        ];
    }
}
