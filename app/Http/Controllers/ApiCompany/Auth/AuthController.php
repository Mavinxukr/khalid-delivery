<?php

namespace App\Http\Controllers\ApiCompany\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

use App\Contracts\Company\Auth\AuthInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }
    /**
     * @api {post} company/login  Login User with email #Screen 1
     * @apiName  Login User
     * @apiVersion 1.1.1
     * @apiGroup Company  Auth
     * @apiParam {String} email Email
     * @apiParam {String} password Password
     * @apiSampleRequest  company/login
     */

    public function login(LoginRequest $request)
    {
        return $this->auth->login($request);
    }

    /**
     * @api {post} company/logout  Logout User
     * @apiName Logout User
     * @apiVersion 1.1.1
     * @apiGroup Company Auth
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  company/logout
     */

    public function logout(Request $request)
    {
        return $this->auth->logout($request);
    }
}
