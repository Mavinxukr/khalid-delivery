<?php

namespace App\Http\Controllers\ApiClient\Profile;

use App\Helpers\HashHelper;
use App\Helpers\TransJsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileEmailRequest;
use App\Http\Requests\ProfileRequest;
use App\Contracts\Client\Profile\ProfileInterface;
use App\Notifications\PasswordRestore;
use App\Notifications\PasswordUpdate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    /**
     * @api {post} client/forget-password   Forget Password
     * @apiName Forget Password
     * @apiVersion 1.1.1
     * @apiGroup Client Profile
     * @apiParam {String} email User email
     * @apiSampleRequest  client/forget-password
     */

    public function forgetPassword(ProfileEmailRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        if(!$user){
            return TransJsonResponse::toJson(false, null, 'This email not found!', 404);
        }
        $pass = $this->updateAfterResetPass($user);
        $user->notify(new PasswordUpdate($pass,$user));
        return TransJsonResponse::toJson(true, null,
            'We have sent, to you, a new password to enter the mail!', 200);
    }

    public function updateAfterResetPass(User $user)
    {
        $pass = Str::random(14);
        $user->update([
            'password' => bcrypt($pass)
        ]);
        return $pass;
    }
}
