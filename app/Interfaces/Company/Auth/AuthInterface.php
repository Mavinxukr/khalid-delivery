<?php


namespace App\Interfaces\Company\Auth;


interface AuthInterface
{
    public function login($data);
    public function logout($data);
}
