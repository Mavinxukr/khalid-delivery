<?php


namespace App\Repositories\Client;


use App\Helpers\AuthSocialHelper;
use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Auth\AuthSocialInterface;
use App\User;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class AuthSocialRepository implements AuthSocialInterface
{
    private  $role;

    public function __construct()
    {
        $this->role = Role::whereName('user')
                        ->value('id');
    }
    public function authSocial(string $token, string $driver, string  $secret = null)
    {
        try{
            $socialUser = is_null($secret) ? Socialite::driver($driver)->userFromToken($token) :
                                             Socialite::driver($driver)->userFromTokenAndSecret($token, $secret);

            dd($socialUser);

            $foundUser = User::where('social_key', $socialUser->getId())
                                ->where('social_driver',$driver)
                                ->first();
        return $this->authLogic($socialUser, $foundUser, $driver);
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false, null,
                "Some error with your $driver token", 401);
        }
    }
    public function authLogic($socialUser, $localUser, string $driver)
    {
        if (is_null($localUser) || !$localUser->edit){
            $localUser = AuthSocialHelper::validateUserAndAuth($driver,$socialUser,$localUser);
            $localUser->roles()->sync($this->role);
        }
        $user = $this->format($localUser);
        return TransJsonResponse::toJson(true, $user, 'User was authorization', 201);

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
}
