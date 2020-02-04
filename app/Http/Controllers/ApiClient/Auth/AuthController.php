<?php

namespace App\Http\Controllers\ApiClient\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Contracts\Client\Auth\AuthInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    private $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @api {post} client/register  Register User with email #Screen 0.3
     * @apiName Register User
     * @apiVersion 1.1.1
     * @apiGroup Client Auth
     * @apiParam {String} email Email
     * @apiParam {String} password Password
     * @apiParam {String} password_confirmation Password confirmation
     * @apiSampleRequest  client/register
     */


    public function register(RegisterRequest $request)
    {
        return $this->auth->register($request);
    }

    /**
     * @api {post} client/login  Login User with email #Screen 0.4
     * @apiName  Login User
     * @apiVersion 1.1.1
     * @apiGroup Client  Auth
     * @apiParam {String} email Email
     * @apiParam {String} password Password
     * @apiSampleRequest  client/login
     */

    public function login(LoginRequest $request)
    {
        return $this->auth->login($request);
    }

    /**
     * @api {post} client/logout  Logout User
     * @apiName Logout User
     * @apiVersion 1.1.1
     * @apiGroup Client Auth
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/logout
     */

    public function logout(Request $request)
    {
        return $this->auth->logout($request);
    }

    public function google()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }
    public function googleCallback(Request $request)
    {
        $user = Socialite::driver('google')
                ->stateless()
                ->user();
        dd($user);
    }

    public function facebook()
    {
        return Socialite::driver('facebook')
            ->stateless()
            ->redirect();
    }
    public function facebookCallback(Request $request)
    {
        $user = Socialite::driver('facebook')
            ->stateless()
            ->user();
        dd($user);
    }

    public function snapchat()
    {
        return Socialite::driver('snapchat')
            ->stateless()
            ->redirect();
    }
    public function snapchatCallback(Request $request)
    {
        $user = Socialite::driver('snapchat')
            ->stateless()
            ->user();
        dd($user);
    }

    public function twitter()
    {
         return Socialite::driver('Twitter')
             ->redirect();
    }
    public function twitterCallback(Request $request)
    {
        $user =  Socialite::driver('Twitter')
            ->user();
        dd($user);
    }


    public function apple()
    {
        return Socialite::driver("sign-in-with-apple")
            ->scopes(["name", "email"])
            ->redirect();
    }


    public function appleCallback()
    {
        $user = Socialite::driver("sign-in-with-apple")
            ->user()->token;

        dd($user);


        $user1 = Socialite::driver("sign-in-with-apple")
                ->userFromToken($user->token);

        dd($user1);


    }


}
