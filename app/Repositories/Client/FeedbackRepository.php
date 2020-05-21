<?php


namespace App\Repositories\Client;


use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Feedback\FeedbackInterface;
use App\Contracts\FormatInterface;
use App\Models\Feedback\CompanyFeedback;
use App\Models\Feedback\Feedback;
use App\Models\Feedback\FeedbackTemplate;
use App\Models\Order\Order;
use App\Models\Provider\Provider;
use Illuminate\Http\Request;

class FeedbackRepository implements FeedbackInterface
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
        $deniedStatus = ['wait','new'];

        if (!in_array($order->status, $deniedStatus)) {
            $feedback = Feedback::create([
                'comment'    => $data->comment,
                'who_id'     => $data->user()->id,
                'order_id'   => $order->id,
                'whom_id'    => $order->provider_id,
                'star'       => $data->star
            ]);
            return TransJsonResponse::toJson(true, $this->format($feedback),'Comment was added', 201);
        }else{
            return TransJsonResponse::toJson(false, null,
                "Comment will not be add in status - $order->status", 400);
        }

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
        if ($data instanceof Provider){
            return [
                'id'            => $data->id,
                'name'          => $data->name,
                'image'         => ImageLinker::linker($data->image),
                'description'   => $data->description
            ];
        }

        if ($data  instanceof Feedback){
            return [
                'company_name'  => $data->company->name,
                'body_feedback' => $data->comment,
                'date_feedback' => $data->created_at->toDateString()
            ];
        }else{
            return  [
                'id'            => $data->id,
                'comment'       => $data->body ?? $data->comment
            ];
        }

    }
    public function getCompanyForFeedback(Request $request)
    {
        $company = collect($request->user()->orderForFeedback)->map(function ($item){
            return $this->format($item->provider);
        });
        return TransJsonResponse::toJson(true,$company,'All company for feedback', 200);
    }

    public function storeCompanyFeedback(Request $request)
    {
        CompanyFeedback::create([
            'name'          => $request->comment,
            'provider_id'   => $request->company_id,
            'star'          =>$request->star,
            'user_id'       => $request->user()->id
        ]);
        return TransJsonResponse::toJson(true,null,'Successfully created', 200);
    }
}
