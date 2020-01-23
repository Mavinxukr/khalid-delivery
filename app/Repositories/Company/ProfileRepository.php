<?php


namespace App\Repositories\Company;


use App\Helpers\ActionSaveImage;
use App\Helpers\CompanyProfileUpdate;
use App\Helpers\TransJsonResponse;
use App\Contracts\Company\Profile\ProfileInterface;
use App\Contracts\FormatInterface;
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
                        ->updateOrCreate(array_filter($request->all()));
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
                                        ->get()->except('provider_id');
        return TransJsonResponse::toJson(true, $creditCard,'Updated company credit card', 201);
    }

    public function format($data)
    {
        $hasCard = !is_null($data->creditCard) ? true : false;
        return [
            'id'                     => $data->id,
            'image'                  => isset($data->image ) ?
                                     env('APP_URL_IMAGE').$data->image : null,
            'company_name'           => $data->name,
            'phone_number'           => $data->phone_number,
            'email'                  => $data->email,
            'type_company'           => $data->categories->type,
            'website'                => $data->website,
            'chamber_of_commerce'    => $data->chamber_of_commerce,
            'hasCard'                => $hasCard,
            'working_hours'          => $data->schedule,
            'languages'              => $data->languages()->get(),
            'count_feedback'         => $data->feedback->count()
        ];


    }

}
