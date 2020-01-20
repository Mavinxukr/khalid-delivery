<?php


namespace App\Repositories\Client;


use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Order\CartInterface;
use App\Contracts\FormatInterface;
use App\Models\Order\Cart;

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
         Cart::updateOrCreate([
            'user_id'       => $data->user()->id,
            'product_id'    => $data->product_id
        ], $data->all() + [
            'user_id' => $data->user()->id
            ]);
         return TransJsonResponse::toJson(true,null,'Successfully add to cart', 201);

    }

    public function update($data, int $id)
    {
        Cart::whereId($id)
                    ->update([
                        'quantity'  => $data->quantity > 0 ? $data->quantity : 1
                    ]);
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
