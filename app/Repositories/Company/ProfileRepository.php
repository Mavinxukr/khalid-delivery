<?php


namespace App\Repositories\Company;


use App\Helpers\ActionSaveImage;
use App\Helpers\CompanyProfileUpdate;
use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Company\Profile\ProfileInterface;
use App\Contracts\FormatInterface;
use App\Models\Order\Order;
use App\Models\Provider\Language;
use App\Models\Provider\Provider;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProfileRepository implements ProfileInterface
{

    public function getCompanyProfile(User $user)
    {
        $company = $this->format($user->company);
        $company['orders_list'] = Order::where('provider_id', $user->company->id)
            ->with('extends')
            ->get()
            ->map(function ($item) use ($user){
                return $this->formatOrder($item, $user->company->categories->type);
            });
        return TransJsonResponse::toJson(true,$company,
                            'Get user\'s company',200);
    }

    public function updateCompanyProfile(Request $request)
    {
        $request->user()
                        ->company
                        ->update(array_filter($request->except('image')));
        $company                         = $request->user()->company;
        $company->image                  = isset($request->image)        ?
                                          ActionSaveImage::updateOrCreateImage($request->image,$company,'provider'):
                                          $company->image;
       $company->save();
       $result = $this->format($company);
       return TransJsonResponse::toJson(true, $result,'Updated company', 201);
    }

    public function updateLanguage(Provider $provider , string $ids = null)
    {
        CompanyProfileUpdate::updateCompanyLanguage($provider, $ids);

        return TransJsonResponse::toJson(true, null,'Updated company languages', 201);

    }

    public function getLanguage()
    {
        $language = Language::orderBy('name','ASC')
                              ->get(['id','name']);
        return TransJsonResponse::toJson(true, $language,'Get language company', 201);
    }

    public function getSchedule(Request $request)
    {
      $schedule = $request->user()->company->schedule ?? null;
      return TransJsonResponse::toJson(true, $schedule,'Get schedule company', 201);
    }

    public function updateSchedule( Request $request)
    {
        $request->user()
                        ->company
                        ->schedule()
                        ->updateOrCreate(['provider_id' => $request->user()->company->id],
                            array_filter($request->all()));
        $schedule = $request->user()
                            ->company
                            ->schedule;
        return TransJsonResponse::toJson(true, $schedule,'Updated company schedule', 201);
    }

    public function getCreditCard(Request $request)
    {
        $card = $request->user()->company->creditCard ?? null;
        return TransJsonResponse::toJson(true, $card,'Get company credit card', 201);

    }

    public function updateCreditCard(Request $request)
    {
        $request->user()
                        ->company
                        ->creditCard()
                        ->updateOrCreate(
                            ['provider_id' => $request->user()->company->id],
                            array_filter($request->all() +
                            ['provider_id' => $request->user()->company->id]
                        ));
        $creditCard =  $request->user()
                                        ->company
                                        ->creditCard
                                        ->get();
        return TransJsonResponse::toJson(true, $creditCard,'Updated company credit card', 201);
    }

    public function format($data, $order=false)
    {
        $hasCard = !is_null($data->creditCard) ? true : false;
        return [
            'id'                     => $data->id,
            'image'                  => ImageLinker::linker($data->image),
            'company_id'             => $data->company_number,
            'company_name'           => $data->name,
            'phone_number'           => $data->phone_number,
            'email'                  => $data->email,
            'type_company'           => $data->categories->type,
            'website'                => $data->website,
            'chamber_of_commerce'    => $data->chamber_of_commerce,
            'hasCard'                => $hasCard,
            'working_hours'          => $data->schedule,
            'languages'              => $data->languages()->get(),
            'count_feedback'         => $data->companyFeedback->count(),
            'rating'                 => $data->companyFeedback->avg('star')
        ];
    }

    public function formatOrder($data, $type)
    {
        if($type === 'service') {
            return [
                'id' => $data->id,
                'name' => $data->name,
                'place' => $data->place,
                'comment' => $data->comment,
                'date_delivery' => $data->date_delivery->toDateString(),
                'date_delivery_from' => $data->date_delivery_from,
                'date_delivery_to' => $data->date_delivery_to,
                'callback_time' => $data->callback_time,
                'cost' => $data->cost,
                'status' => $data->status,
                'can_take' => is_null($data->provider_id) ? true : false,
                'can_cancel' => $data->company_id === $data->provider_id,
                'extends' => $data->extends()->with('files')->get(),
            ];

        }else{
            if ($data->flag){
                return [
                    'id'                 => $data->id,
                    'name'               => $data->title,
                    'cost'               => $data->price,
                    'image'              => ImageLinker::linker($data->image),
                    'category'           => $data->categories->type,
                    'description'        => $data->description,
                    'weight'             => $data->weight,
                    'canceled'           => $data->pivot->canceled,
                ];
            }else{
                return [
                    'id'                 => $data->id,
                    'name'               => $data->name,
                    'place'              => $data->place,
                    'date_delivery'      => $data->date_delivery->toDateString(),
                    'date_delivery_from' => $data->date_delivery_from,
                    'cost'               => $data->cost,
                    'image'              => ImageLinker::linker($data->products()->value('image')),
                    'status'             => $data->status,
                    'comment'            => $data->comment,
                    'callback_time'      => $data->callback_time
                ];
            }

        }
    }
}
