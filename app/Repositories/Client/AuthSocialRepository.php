<?php


namespace App\Repositories\Client;


use App\Helpers\AuthSocialHelper;
use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Auth\AuthSocialInterface;
use App\Contracts\FormatInterface;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class AuthSocialRepository implements AuthSocialInterface, FormatInterface
{
    private $role;

    public function __construct(Role $role)
    {
        $this->role = Role::whereName('user')->value('id');
    }

    public function authGoogle(string $token)
    {
        try {
            $googleUser = Socialite::driver('google')
                ->userFromToken($token)
                ->user;
            $user = User::whereEmail($googleUser['email'])
                            ->where('social_key', $googleUser['id'])
                            ->where('social_driver','google')
                            ->first();
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false, null,
                'Some error with your google token', 401);
        }
       if (is_null($user) || !$user->edit){
           $user = AuthSocialHelper::validateUserAndAuth('google',$googleUser);
           $user->roles()->sync($this->role);
       }
        $user = $this->format($user);
        return TransJsonResponse::toJson(true, $user, 'User was created', 201);

    }

    public function authFacebook(string $token)
    {
        try {
            $facebookUser = Socialite::driver('facebook')
                ->userFromToken($token);
            $user = User::where('social_driver','facebook')
                            ->where('social_key', $facebookUser->id)
                            ->first();
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false, null,
                'Some error with your facebook token', 401);
        }
        if (is_null($user) || !$user->edit){
            $user = AuthSocialHelper::validateUserAndAuth('facebook',$facebookUser, $user);
            $user->roles()->sync($this->role);
        }
        $user = $this->format($user);
        return TransJsonResponse::toJson(true, $user, 'User was created', 201);
    }

    public function authTwitter(string $token, string $secret)
    {
        try {
            $twitterUser = Socialite::driver('Twitter')
                ->userFromTokenAndSecret($token, $secret);
            $user = User::where('social_key',$twitterUser->id)
                                ->where('social_driver','twitter')
                                ->first();
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false, null,
                'Some error with your twitter token', 401);
        }
        if (is_null($user) || !$user->edit){
            $user = AuthSocialHelper::validateUserAndAuth('twitter',$twitterUser );
            $user->roles()->sync($this->role);
        }
        $user = $this->format($user);
        return TransJsonResponse::toJson(true, $user, 'User was created', 201);

    }

    public function authSnapchat(string $token)
    {
        try {
            $snapChatUser = Socialite::driver('snapchat')
                ->userFromToken($token);
            $user = User::where('social_key', $snapChatUser->id)
                            ->where('social_driver','snapchat')
                            ->first();
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false, null,
                'Some error with your snapchat token', 401);
        }
        if (is_null($user) || !$user->edit){

            $user = AuthSocialHelper::validateUserAndAuth('snapchat',$snapChatUser );
            $user->roles()->sync($this->role);
        }
        $user = $this->format($user);
        return TransJsonResponse::toJson(true, $user, 'User was created', 201);
    }

    public function format($data)
    {
        $hasCard = true ? !is_null($data->creditCard) : false;
        return [
            'id'         => $data->id,
            'user_name'  => $data->first_name. ' '. $data->last_name ?? '' ,
            'first_name' => $data->first_name ?? '',
            'last_name'  => $data->last_name ?? '',
            'email'      => $data->email,
            'image'      => ImageLinker::linker($data->image),
            'role'       => $data->roles()->value('name') ?? null,
            'token'      => 'Bearer '.$data->createToken('Delivery')
                            ->accessToken,
            'has_card'   => $hasCard

        ];
    }

    public function authSocial(string $token, string $driver, string  $secret = null)
    {
        if ($driver === 'google') return $this->authGoogle($token);
        if ($driver === 'facebook') return $this->authFacebook($token);
        if ($driver === 'twitter') return $this->authTwitter($token, $secret);
        if ($driver === 'snapchat') return $this->authSnapchat($token);
    }
}
