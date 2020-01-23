<?php


namespace App\Contracts\Client\Auth;


use App\Contracts\FormatInterface;

interface AuthInterface extends FormatInterface
{
    public function register($data);
    public function login($data);
    public function logout($data);
}
