<?php


namespace App\Contracts\Client\Auth;


interface AuthInterface
{
    public function register($data);
    public function login($data);
    public function logout($data);
}
