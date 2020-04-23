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
    echo phpinfo();
});

Route::get('google','ApiClient\Auth\AuthController@google');
Route::get('callback/google','ApiClient\Auth\AuthController@googleCallback');

Route::get('facebook','ApiClient\Auth\AuthController@facebook');
Route::get('callback/facebook','ApiClient\Auth\AuthController@facebookCallback');

Route::get('twitter','ApiClient\Auth\AuthController@twitter');
Route::get('callback/twitter','ApiClient\Auth\AuthController@twitterCallback');

Route::get('snapchat','ApiClient\Auth\AuthController@snapchat');
Route::get('callback/snapchat','ApiClient\Auth\AuthController@snapchatCallback');


Route::get('apple','ApiClient\Auth\AuthController@apple');
Route::post('callback/apple','ApiClient\Auth\AuthController@appleCallback');


Route::view('/checkout','payment.checkout');

Route::get('/tax/layout',function (){
    return view('tax.layout');
});

Route::get('/tax/{id}/simple',function ($id){
    $headers = \App\Models\Invoice\InvoiceTemplate::all()->pluck('value', 'key');
    $order = \App\Models\Order\Order::findOrFail($id);
    return view('tax.simple', [
        'order'     => $order,
        'headers'   => $headers,
    ]);
});
Route::get('/tax/{id}/detail',function ($id){
    $headers = \App\Models\Invoice\InvoiceTemplate::all()->pluck('value', 'key');
    $order = \App\Models\Order\Order::findOrFail($id);
    return view('tax.detail', [
        'order'     => $order,
        'headers'   => $headers,
    ]);
});
Route::get('/tax/{id}/invoice',function ($id){
    $headers = \App\Models\Invoice\InvoiceTemplate::all()->pluck('value', 'key');
    $order = \App\Models\Order\Order::findOrFail($id);
    return view('tax.invoice', [
        'order'     => $order,
        'headers'   => $headers,
    ]);
});
