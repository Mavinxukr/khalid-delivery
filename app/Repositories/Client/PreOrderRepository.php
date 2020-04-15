<?php


namespace App\Repositories\Client;


use App\Contracts\Client\FAQ\FaqInterface;
use App\Contracts\Client\Order\PreOrderInterface;
use App\Helpers\TransJsonResponse;
use App\Models\FAQ\Faq;
use App\Models\Order\PreOrder;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class PreOrderRepository implements PreOrderInterface
{

    public function store($data)
    {
        $preOrder = $data->user()->preOrder()->create();
        return TransJsonResponse::toJson(true, ['id' => $preOrder->id],
            'Create new preOrder', 201);
    }

    public function update(Request $request, int $id)
    {
        $preOrder = $request->user()->preOrder()->findOrFail($id);
        $components = explode(';', $request->components);
        $services = [];
        foreach ($components as $k => $item) {
            $values = explode(',', $item);
            foreach ($values as $value) {
                $temp = explode('=', $value);
                $params[$temp[0]] = $temp[1];
            }
            if(!is_null(Product::findOrFail($params['product_id'])->parent_id)){
                $services[] = $preOrder->details()->updateOrCreate([
                    'product_id' => $params['product_id']
                ], [
                    'answer'    => $params['answer'] ? $params['answer'] : null,
                    'count'     => $params['count'] ? $params['count'] : null,
                ]);
            }
        }

        $sum = 0;
        foreach ($services as $service){
            $product = $service->product;
            switch ($product->answer_type){
                case "count":
                    $sum = $sum + ($product->price * $service->count);
                    break;
                case "boolean":
                    if($service->answer === 'true') $sum = $sum + $product->price;
                    break;
                case "boolean&count":
                    if($service->answer === 'true') $sum = $sum + ($product->price * $service->count);
                    break;
            }
        }

        $preOrder->update([
            'price'     => $sum,
            'status'    => 'pre-order',
        ]);
        return TransJsonResponse::toJson(true, $this->format($preOrder->fresh()),
            'Store all answers', 200);
    }

    public function format($data)
    {
        return [
            'id'        => $data->id,
            'status'    => $data->status,
            'price'     => $data->price,
        ];
    }
}
