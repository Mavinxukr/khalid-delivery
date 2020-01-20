<?php


namespace App\Contracts\Company\Auth;


interface AuthInterface
{
    public function login($data);
    public function logout($data);
}
