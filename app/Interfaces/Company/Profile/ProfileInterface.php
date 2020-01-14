<?php


namespace App\Interfaces\Company\Profile;


use App\User;

interface ProfileInterface
{
    public function getCompanyProfile(User $data);
}
