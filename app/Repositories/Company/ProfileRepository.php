<?php


namespace App\Repositories\Company;


use App\Helpers\TransJsonResponse;
use App\Interfaces\Company\Profile\ProfileInterface;
use App\Interfaces\FormatInterface;
use App\User;

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
       return [
           'id'             => $data->id,
           'image'          => isset($data->image ) ?
                            env('APP_URL_IMAGE').$data->image : null,
           'company_name'   => $data->name,
           'phone'          => $data->phone,
           'email'          => $data->email,
           'type_company'   => $data->categories->type,
           'website'        => $data->website,
           'working_hours'  => $data->providerSetting->schedule
       ];
    }
}
