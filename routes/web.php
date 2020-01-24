<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('admin');
});


Route::get('phpinfo',function (){
    return phpinfo();
});

Route::get('google','ApiClient\Auth\AuthController@google');
Route::get('callback/google','ApiClient\Auth\AuthController@googleCallback');

Route::get('facebook','ApiClient\Auth\AuthController@facebook');
Route::get('callback/facebook','ApiClient\Auth\AuthController@facebookCallback');

Route::get('twitter','ApiClient\Auth\AuthController@twitter');
Route::get('callback/twitter','ApiClient\Auth\AuthController@twitterCallback');

Route::get('snapchat','ApiClient\Auth\AuthController@snapchat');
Route::get('callback/snapchat','ApiClient\Auth\AuthController@snapchatCallback');

