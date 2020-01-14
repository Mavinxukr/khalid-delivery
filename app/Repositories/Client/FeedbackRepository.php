<?php


namespace App\Repositories\Client;


use App\Helpers\TransJsonResponse;
use App\Interfaces\Client\Feedback\FeedbackInterface;
use App\Interfaces\FormatInterface;
use App\Models\Feedback\Feedback;
use App\Models\Feedback\FeedbackTemplate;
use App\Models\Order\Order;

class FeedbackRepository implements FeedbackInterface, FormatInterface
{

    public function index()
    {
        $feedback = FeedbackTemplate::orderBy('id', 'DESC')
                ->get()
                ->map(function ($feedback){
                    return $this->format($feedback);
                });
        return TransJsonResponse::toJson(true,$feedback,'All template for feedback', 200);
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function store($data)
    {
        $order = Order::findOrFail($data->order_id);
        $feedback =  Feedback::create([
            'comment'       => $data->comment,
            'user_id'       => $data->user()->id,
            'order_id'      => $order->id,
            'company_id'    => $order->provider_id
        ]);

        return TransJsonResponse::toJson(true, $this->format($feedback),'Comment was added', 201);
    }

    public function myFeedback($data)
    {
        $myFeedback =  $data->user()
                            ->myFeedback
                            ->map(function ($feedback){
                return $this->format($feedback);
            });
        return TransJsonResponse::toJson(true, $myFeedback,'All template for feedback', 200);
    }

    public function format($data)
    {
        if ($data  instanceof Feedback){
            return [
                'company_name'  => $data->company->name,
                'body_feedback' => $data->comment,
                'date_feedback' => $data->created_at->toDateString()
            ];
        }else{
            return  [
                'id'        => $data->id,
                'comment'   => $data->body ?? $data->comment
            ];
        }

    }
}
