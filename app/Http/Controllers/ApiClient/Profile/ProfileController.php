<?php

namespace App\Http\Controllers\ApiClient\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Interfaces\Client\Profile\ProfileInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $profile;

    public function __construct(ProfileInterface $profile)
    {
        $this->profile = $profile;
    }

    /**
     * @api {post} client/profiles/{id} Update profile #Screen №31
     * @apiName  Update profile
     * @apiVersion 1.1.1
     * @apiGroup Client Profile
     * @apiParam {String} first_name First name
     * @apiParam {String} last_name Last name
     * @apiParam {String} phone Phone
     * @apiParam {String} email Email
     * @apiParam {String} password Password
     * @apiParam {File} image Image
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/profiles/{id}
     */

    public function update(Request $request, int $id)
    {
        return $this->profile->update($request, $id);
    }

    /**
     * @api {get} client/profiles  Get user by token #Screen №31
     * @apiName  Get user by token
     * @apiVersion 1.1.1
     * @apiGroup Client Profile
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/profiles
     */

    public function getUserByToken(Request $request)
    {
        return $this->profile->getUserByToken($request);
    }

    /**
     * @api {get} client/user-profiles-comments  Get user profile #Screen №19,20
     * @apiName  Get user profile
     * @apiVersion 1.1.1
     * @apiGroup Client Profile
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/user-profiles-comments
     */

    public function getProfileComments(Request $request)
    {
        return $this->profile->getProfileComments($request->user()->id);
    }
}
