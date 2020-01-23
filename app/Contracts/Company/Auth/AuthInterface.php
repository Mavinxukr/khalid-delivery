<?php


namespace App\Contracts\Company\Auth;


use App\Contracts\FormatInterface;

interface AuthInterface extends FormatInterface
{
    public function login($data);
    public function logout($data);
}
