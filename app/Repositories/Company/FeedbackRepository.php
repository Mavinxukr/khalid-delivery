<?php


namespace App\Repositories\Company;


use App\Helpers\TransJsonResponse;
use App\Contracts\Company\Feedback\FeedbackInterface;
use App\Contracts\FormatInterface;
use App\Models\Feedback\Feedback;
use App\Models\Feedback\FeedbackTemplate;
use App\Models\Order\Order;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $order = Order::findOrFail($request->order_id);


        return TransJsonResponse::toJson(true, $this->format($order),'Comment was added', 201);
    }

    public function myFeedback(Request $request)
    {
        $myFeedback =  $request->user()
            ->myFeedback
            ->map(function ($feedback){
                return $this->format($feedback);
            });
        return TransJsonResponse::toJson(true, $myFeedback,'Get my feedback', 200);
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
