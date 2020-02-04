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
            ->redirect();
    }


    public function appleCallback()
    {
        $user = Socialite::driver("sign-in-with-apple");

        $token = 'eyJraWQiOiJBSURPUEsxIiwiYWxnIjoiUlMyNTYifQ.eyJpc3MiOiJodHRwczovL2FwcGxlaWQuYXBwbGUuY29tIiwiYXVkIjoiY29tLmFwcGFkbWlucG9ydGFsIiwiZXhwIjoxNTgwODE4NTk1LCJpYXQiOjE1ODA4MTc5OTUsInN1YiI6IjAwMTA2OS45ODMyY2NmNTgyZjE0MzE0OGQwYzc1ZDU1NGI4NDc5Yy4xMTAxIiwiYXRfaGFzaCI6IjU3S2tiSGZRaS11YVNfcjZ0NHVKc2ciLCJlbWFpbCI6Imt4NmQ2YWRodHdAcHJpdmF0ZXJlbGF5LmFwcGxlaWQuY29tIiwiZW1haWxfdmVyaWZpZWQiOiJ0cnVlIiwiaXNfcHJpdmF0ZV9lbWFpbCI6InRydWUiLCJhdXRoX3RpbWUiOjE1ODA4MTc5OTR9.iB6s7fCZl0hsV2I_SDHsZRSNK-vCd5XDO4HFHuieUaiKA8nuD6DsJnJK6Qzj96pUj1R8xFPDmabqONGMpdytnSzk8Q_I7S-yyvDYdfT9eT-n-LaxIPe8FMz2FlfE0PGA7xCiHhSVpYucW-p6k3mhX4qfU9vEEV37qeCHZd06nytbPZqxMBHad8K1hsMJlzso7Jvf-oy9HlvgUagWJ8UhNetlT0llNI0dAUnKJF3jT_CKLpgJwhyUxWEiSYkryQfsFJNIYeRchyrmns8y1xBqcsOQDAnvnL5TXf8ODRzIYXI4JX8TyUs2N4YtFikGitiRnKlUbwI_ye-ubMPCndaoQA';

        dd($user->getUserByToken($token));


    }


}
