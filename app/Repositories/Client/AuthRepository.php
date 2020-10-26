<?php


namespace App\Repositories\Client;

use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Auth\AuthInterface;
use App\Contracts\FormatInterface;
use App\User;
use Config;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AuthRepository implements AuthInterface
{

    public function register($data)
    {
        $role = Role::where('name','user')->first();
        try {
            $user = User::create($data->except('password') + [
                    'password' => bcrypt($data->password),

                ]);
            $user->promo_code = rand(10**6,10**7);
            $user->save();
            $user->roles()->attach($role->id);
            $user = $this->format($user);
            return TransJsonResponse::toJson(true, $user, 'User was created', 201);
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false,null,$exception->getMessage(), 400);
        }
    }

    public function login($data)
    {
     try{
         Auth::attempt([
                 'email'    => $data->email,
                 'password' => $data->password
             ]);
         $user = Auth::user();
         if (!is_null($user)){
             if (is_null($user->promo_code)){
                 $user->promo_code = rand(10**6,10**7);
                 $user->save();
             }
             $role = $user->roles()->value('name');
             if ($role !== 'user')  {
                 throw new \Exception('Log in is only for role - user !');
             }
             $data =  $this->format($user);
             return TransJsonResponse::toJson(true, $data,'Login success',200);
         }
         throw new \Exception('Invalid email or password');
     }catch (\Exception $exception){
         return TransJsonResponse::toJson(false,null,$exception->getMessage(),400);
     }
    }

    public function logout($request)
    {
        try {
            $request->user()->token()->revoke();
            return TransJsonResponse::toJson(true,null,'Logout success',200);
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false,null,$exception->getMessage(),400);
        }
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
            'role'       => $data->roles()->first()->name ?? null,
            'token'      => 'Bearer '.$data->createToken('Delivery')
                    ->accessToken,
            'has_card'   => $hasCard

        ];
    }
}
