<?php


namespace App\Contracts\Client\Auth;

use App\Contracts\FormatInterface;

interface AuthSocialInterface extends FormatInterface
{
    public function authSocial(string $token, string $driver, string $secret = null);
    public function authLogic($socialUser, $localUser, string  $driver);

}
