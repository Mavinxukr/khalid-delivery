<?php


namespace App\Repositories\Company;


use App\Helpers\ActionSaveImage;
use App\Helpers\CompanyProfileUpdate;
use App\Helpers\TransJsonResponse;
use App\Interfaces\Company\Profile\ProfileInterface;
use App\Interfaces\FormatInterface;
use App\Models\Provider\Language;
use App\Models\Provider\Provider;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProfileRepository implements ProfileInterface, FormatInterface
{

    public function getCompanyProfile(User $user)
    {
        $company = $this->format($user->company);

        return TransJsonResponse::toJson(true,$company,
                            'Get user\'s company',200);
    }

    public function format($data)
    {
        if ($data instanceof Language){
            $result = [
                'id'                    => $data->id,
                'name'                  => $data->name
            ];
        }else{
            $result =  [
                'id'                     => $data->id,
                'image'                  => isset($data->image ) ?
                                         env('APP_URL_IMAGE').$data->image : null,
                'company_name'           => $data->name,
                'phone'                  => $data->phone_number,
                'email'                  => $data->email,
                'type_company'           => $data->categories->type,
                'website'                => $data->website,
                'chamber_of_commerce'    => $data->chamber_of_commerce,
                'working_hours'          => $data->schedule,
                'languages'              => $data->languages()->get()
            ];
        }
       return $result ;
    }

    public function updateCompanyProfile(Request $request)
    {
       $company                         = $request->user()->company;
       $company->name                   = $request->name                ?? $company->name;
       $company->phone_number           = $request->phone               ?? $company->phone_number;
       $company->email                  = $request->email               ?? $company->email;
       $company->website                = $request->website             ?? $company->website;
       $company->chamber_of_commerce    = $request->chamber_of_commerce ?? $company->chamber_of_commerce;
       $company->category_id            = $request->category_id         ?? $company->category_id;
       $company->image                  = isset($request->image)        ?
                                          ActionSaveImage::updateImage($request->image, $company,'provider'):
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
                              ->get()
                              ->map(function ($language){
                                  return $this->format($language);
                              })  ;
        return TransJsonResponse::toJson(true, $language,'Get language company', 201);
    }

    public function getSchedule(Request $request)
    {
      $schedule = $request->user()->company->schedule;
      return TransJsonResponse::toJson(true, $schedule,'Get schedule company', 201);
    }

    public function updateSchedule( Request $request)
    {
        $schedule               = $request->user()->company->schedule;
        $schedule->monday       = $request->monday      ?? $schedule->monday;
        $schedule->tuesday      = $request->tuesday     ?? $schedule->tuesday;
        $schedule->wednesday    = $request->wednesday   ?? $schedule->wednesday;
        $schedule->thursday     = $request->thursday    ?? $schedule->thursday;
        $schedule->friday       = $request->friday      ?? $schedule->friday;
        $schedule->sunday       = $request->sunday      ?? $schedule->sunday;
        $schedule->save();
        return TransJsonResponse::toJson(true, $schedule,'Updated company schedule', 201);
    }
}
