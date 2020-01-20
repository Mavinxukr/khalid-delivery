<?php


namespace App\Helpers;


use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthSocialHelper
{
    public static function validateUserAndAuth (string $driver,$socialUser, $localUser = null)
    {
        $updateBy  ['social_driver'] = $driver;
        $createData = [];
        $nameUser = isset($socialUser->name) ? explode(' ',$socialUser->name) : null ;

        if ($driver === 'google'){
            $updateBy ['email']          = $socialUser['email'];
            $updateBy ['social_key']     = $socialUser['id'];

            $createData ['first_name']   = $socialUser['given_name'] ?? null;
            $createData['last_name']     = $socialUser['family_name'] ?? null;
            $createData ['email']        = $socialUser['email'];
            $createData['social_key']    = $socialUser['id'];
            $createData['social_driver'] = $driver;
            $createData['image']         = $socialUser['picture'] ?? null;

        }
        if ($driver === 'facebook'){
            if (isset($socialUser->avatar_original)){
                $name = Str::random('60').'.jpeg';
                $path = 'image/profile/'. $name;
                if (!is_null($localUser) &&
                            file_exists(storage_path('app/public/').$localUser->image)){
                    Storage::disk('public')->delete($localUser->image);
                }
                Storage::disk('public')->put($path,file_get_contents($socialUser->avatar_original));
            }
            $updateBy ['social_key']     = $socialUser->id;

            $createData ['first_name']   = $nameUser[0] ?? null;
            $createData['last_name']     = $nameUser[1] ?? null;
            $createData ['email']        = $facebookUser->email ?? null;
            $createData['social_key']    = $socialUser->id;
            $createData['social_driver'] = $driver;
            $createData['image']         = $path?? null;
        }
        if ($driver === 'twitter'){
            $updateBy ['social_key']     = $socialUser->id;

            $createData ['first_name']   = $nameUser[0] ?? null;
            $createData['last_name']     = $nameUser[1] ?? null;
            $createData ['email']        = $socialUser->email ?? null;
            $createData['social_key']    = $socialUser->id;
            $createData['social_driver'] = $driver;
            $createData['image']         = $socialUser->avatar?? null;

        }
        if ($driver === 'snapchat'){
            $updateBy ['social_key']     = $socialUser->id;

            $createData ['first_name']   = $nameUser[0] ?? null;
            $createData['last_name']     = $nameUser[1] ?? null;
            $createData ['email']        = $socialUser->email ?? null;
            $createData['social_key']    = $socialUser->id;
            $createData['social_driver'] = $driver;
            $createData['image']         = $socialUser->avatar?? null;

        }

        $user =  User::updateOrCreate($updateBy,$createData);

        return $user;
    }
}
