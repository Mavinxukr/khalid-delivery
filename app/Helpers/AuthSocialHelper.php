<?php


namespace App\Helpers;


use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AuthSocialHelper
{

    public static function validateUserAndAuth (string $driver,$socialUser, $localUser = null) : User
    {
        $updateBy['social_driver']    = $driver;
        $updateBy['social_key']       = $socialUser->getId();
        $nameUser                     = !empty($socialUser->getName()) ?
                                         explode(' ',$socialUser->getName()) : null ;
        $updateBy['email']            = $driver === 'google' || $driver === 'apple'? $socialUser->getEmail() : null;

        $createData['first_name']     =  $nameUser[0] ?? null;
        $createData['last_name']      =  $nameUser[1]  ?? null;
        $createData['social_key']     =  $socialUser->getId();
        $createData['social_driver']  =  $driver;
        $createData['image']          =  $socialUser->getAvatar() ?? null;
        $user                         =  User::updateOrCreate($updateBy,$createData);

        return $user;
    }
}
