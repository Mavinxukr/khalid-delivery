<?php


namespace App\Helpers;


use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthSocialHelper
{
    public static function validateUserAndAuth (string $driver,$socialUser, $localUser = null) : User
    {
        $updateBy  ['social_driver'] = $driver;
        $updateBy  ['social_key']    = $socialUser['id'] ?? $socialUser->id;
        $nameUser = isset($socialUser->name) ? explode(' ',$socialUser->name) : null ;
        $createData = [];


        if ($driver === 'google'){
            $updateBy ['email']          = $socialUser['email'];

            $createData ['first_name']   = $socialUser['given_name'] ?? null;
            $createData['last_name']     = $socialUser['family_name'] ?? null;
            $createData ['email']        = $socialUser['email'];
            $createData['social_key']    = $socialUser['id'];
            $createData['social_driver'] = $driver;
            $createData['image']         = $socialUser['picture'] ?? null;

        }else {
            $createData ['first_name']   = $nameUser[0] ?? null;
            $createData['last_name']     = $nameUser[1] ?? null;
            $createData ['email']        = $facebookUser->email ?? null;
            $createData['social_key']    = $socialUser->id;
            $createData['social_driver'] = $driver;
            if ($driver === 'facebook') {
                if (isset($socialUser->avatar_original)) {
                    $name = Str::random('60') . '.jpeg';
                    $path = 'image/profile/' . $name;
                    if (!is_null($localUser) &&
                        file_exists(storage_path('app/public/') . $localUser->image)) {
                        Storage::disk('public')->delete($localUser->image);
                    }
                    Storage::disk('public')->put($path, file_get_contents($socialUser->avatar_original));
                }
                $createData['image'] = $path ?? null;
            }else{
                $createData['image'] = $socialUser->avatar ?? null;
            }
        }
        $user =  User::updateOrCreate($updateBy,$createData);

        return $user;
    }
}
