<?php


namespace Tests\Feature;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AuthUserTest extends TestCase
{

    /** @test */
    public function login_test()
    {
        $data = [];
        $data['email']      = 'admin@gmail.com';
        $data['password']   = '111111';
        $response = $this->json('POST', '/api/login', $data);

        if ($response->status() == 200) {
            $response->assertStatus($response->status())
                ->assertSuccessful();
        }else{
            $this->expectExceptionMessage('Failed login');
        }
    }

    /** @test */
    public function register_test()
    {
        $data = [];
        $data['email']                   = 'admin123465@gmail.com';
        $data['name']                    = 'test_user';
        $data['password']                = '111111';
        $data['password_confirmation']   = '111111';
        $response = $this->json('POST', '/api/register', $data);

        if ($response->status() == 201) {
            $response->assertStatus($response->status())
                ->assertSuccessful();
        }else{
            $this->expectExceptionMessage('Failed register');
        }
    }

    /** @test */
    public function logout_test()
    {
       $user =  User::find(1);
       Auth::login($user);

       $token =  Auth::user()->createToken('Delivery')->accessToken;

       $response = $this->json('POST', '/api/logout',[],[
           'Authorization' =>"Bearer $token"
       ]);

       if ($response->status() == 200){
           $response->assertStatus($response->status())
               ->assertSuccessful();
       }else{
           $this->expectExceptionMessage('Failed logout');
       }
    }



}
