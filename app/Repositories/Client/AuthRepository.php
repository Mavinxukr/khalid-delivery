<?php


namespace App\Repositories\Client;

use App\Helpers\TransJsonResponse;
use App\Interfaces\Client\Auth\AuthInterface;
use App\Interfaces\FormatInterface;
use App\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AuthRepository implements AuthInterface, FormatInterface
{

    public function register($data)
    {
        $role = Role::where('name','user')
                ->first();
        try {
            $user = User::create($data->except('password') + [
                    'password' => bcrypt($data->password)
                ]);
            $user->roles()->attach($role->id);
            $user = $this->format($user);
            return TransJsonResponse::toJson(true, $user, 'User was created', 201);
        }catch (\Exception $exception){
            return TransJsonResponse::toJson(false,null,$exception->getMessage(), 400);
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
            'image'      => isset($data->image ) ?  env('APP_URL_IMAGE').$data->image : null,
            'role'       => $data->roles()->first()->name ?? null,
            'token'      => 'Bearer '.$data->createToken('Delivery')
                            ->accessToken,
            'has_card'   => $hasCard

        ];
    }

    public function login($data)
    {
     try{
         Auth::attempt([
                 'email'    => $data->email,
                 'password' => $data->password
             ]);
         $user = Auth::user();

         if ($user){
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
}
