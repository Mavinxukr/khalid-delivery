<?php

namespace App\Http\Controllers\ApiCompany\Profile;

use App\Http\Controllers\Controller;
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
}
