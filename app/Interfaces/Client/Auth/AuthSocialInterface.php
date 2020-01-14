<?php


namespace App\Interfaces\Client\Auth;


interface AuthSocialInterface
{
    public function authSocial(string $token, string $driver, string $secret = null);
    public function authGoogle(string $token);
    public function authFacebook(string $token);
    public function authTwitter(string $token, string $secret);
    public function authSnapchat(string $token);
}
