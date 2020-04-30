<?php


namespace App\Repositories\Client;


use App\Contracts\Client\FAQ\FaqInterface;
use App\Contracts\Client\Order\PreOrderInterface;
use App\Helpers\TransJsonResponse;
use App\Models\FAQ\Faq;
use App\Models\Order\OrderDetail;
use App\Models\Order\PreOrder;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class PreOrderRepository implements PreOrderInterface
{
    public function store(Request $request)
    {
        $preOrder = $request->user()->preOrder()->create();
        $answers = explode(';', $request->answers);

        foreach ($answers as $k => $item) {
            $values = explode(',', $item);
            foreach ($values as $value) {
                $temp = explode('=', $value);
                $params[$temp[0]] = $temp[1];
            }
            $preOrder->details()->create([
                'query_id' => $params['q'],
                'answer_id' => $params['a'],
            ]);
        }

        $sum = 0;
        foreach ($preOrder->details as $query){
           $sum = $sum + ($query->answer->price);
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
            'price'     => $data->price,
        ];
    }
}
