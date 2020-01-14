<?php


namespace App\Repositories\Company;


use App\Helpers\TransJsonResponse;
use App\Interfaces\Company\Auth\AuthInterface;
use App\Interfaces\FormatInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthInterface, FormatInterface
{
    public function login($data)
    {
        try{
            Auth::attempt([
                'email'    => $data->email,
                'password' => $data->password
            ]);
            $user = Auth::user();

            if (!is_null($user)){
                $roles = $user->roles()->value('name');

                if ($roles !== 'company')  {
                    throw new \Exception('Your role is not equal - company');
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

    public function register($data)
    {
        // TODO: Implement register() method.
    }

    public function format($data)
    {
        return [
            'id'         => $data->id,
            'user_name'  => $data->first_name. ' '. $data->last_name ?? '' ,
            'first_name' => $data->first_name ?? '',
            'last_name'  => $data->last_name ?? '',
            'email'      => $data->email,
            'image'      => isset($data->image ) ?  env('APP_URL_IMAGE').$data->image : null,
            'role'       => $data->roles()->value('name') ?? null,
            'token'      => 'Bearer '.$data->createToken('Delivery')
                            ->accessToken
        ];
    }
}
