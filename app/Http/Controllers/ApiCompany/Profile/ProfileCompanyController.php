<?php

namespace App\Http\Controllers\ApiCompany\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientProfileRequest;
use App\Interfaces\Company\Profile\ProfileInterface;
use Illuminate\Http\Request;

class ProfileCompanyController extends Controller
{
    private $profile;

    public function __construct(ProfileInterface $profile)
    {
        $this->profile = $profile;
    }
    /**
     * @api {get} company/company-profile  Get company profile #Screen 2
     * @apiName  Get company profile
     * @apiVersion 1.1.1
     * @apiGroup Company  Profile
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/company-profile
     */

    public function getClientProfile(Request $request)
    {
        return $this->profile->getCompanyProfile($request->user());
    }

    /**
     * @api {post} company/company-profile/update  Update company profile #Screen 2
     * @apiName  Update company profile
     * @apiVersion 1.1.1
     * @apiGroup Company  Profile
     * @apiParam {String} phone Phone
     * @apiParam {String} name Company_name
     * @apiParam {String} email Email
     * @apiParam {String} website Website
     * @apiParam {String} chamber_of_commerce Chamber of commerce
     * @apiParam {Number} category_id Category Id (1 - food , 2 - service , 3 - market)
     * @apiParam {File} image Image
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/company-profile/update
     */


    public function updateClientProfile(ClientProfileRequest $request)
    {
        return $this->profile->updateCompanyProfile($request);
    }

    /**
     * @api {post} company/company-profile/update-language  Update company profile language #Screen 2
     * @apiName  Update company profile language
     * @apiVersion 1.1.1
     * @apiGroup Company  Profile
     * @apiParam {String} language_ids Ids language ('1,2,4')
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/company-profile/update-language
     */

    public function updateLanguage(Request $request)
    {
        return $this->profile->updateLanguage($request->language_ids);
    }

    /**
     * @api {get} company/company-profile/get-language  Get company profile language #Screen 2
     * @apiName  Get company profile language
     * @apiVersion 1.1.1
     * @apiGroup Company  Profile
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/company-profile/get-language
     */

    public function getLanguage()
    {
        return $this->profile->getLanguage();
    }
}
