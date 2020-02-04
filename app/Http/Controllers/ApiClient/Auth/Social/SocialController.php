<?php

namespace App\Http\Controllers\ApiClient\Auth\Social;

use App\Http\Controllers\Controller;
use App\Contracts\Client\Auth\AuthSocialInterface;
use App\Http\Requests\SocialRequest;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    private $auth;

    public function __construct(AuthSocialInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @api {post} client/auth/{google||facebook||twitter||snapchat||apple}  Auth  with social #Screen 0.4
     * @apiName  Auth  with social
     * @apiVersion 1.1.1
     * @apiGroup Client  Auth
     * @apiParam {String} token Token from SDK
     * @apiParam {String} secret Secret  from SDK !!! Only for auth with twitter
     * @apiSampleRequest  client/auth/{google||facebook||twitter||snapchat||apple}
     */

    public function authSocial(SocialRequest $request, string $driver)
    {
        return $this->auth->authSocial($request->token, $driver, $request->secret);
    }

}
