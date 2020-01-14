<?php


namespace App\Interfaces\Client\Auth;


interface AuthInterface
{
    public function register($data);
    public function login($data);
    public function logout($data);
}
