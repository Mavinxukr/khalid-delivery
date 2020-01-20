<?php


namespace App\Contracts\Client\Auth;

interface AuthSocialInterface
{
    public function authSocial(string $token, string $driver, string $secret = null);
    public function authLogic($socialUser, $localUser, string  $driver);

}
