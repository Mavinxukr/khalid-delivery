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


Route::get('/reward/{sender_id}/recipient-email/{email}','Web\Reward\RewardController@successReward');

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
    $orders = \App\Models\Order\Order::where('provider_id', $id)->get();
    return view('tax.invoice', [
        'orders'        => $orders,
        'provider'      => $orders->first()->provider
    ]);
});

Route::get('/dump-download', function () {
    return "http://delivery.beta/storage/orders/10/checks/FRHIwCr43ZDwTkCeL7H3JtmDwYIEE1aCVGyLs7nn.png";
    //return response()->download("http://delivery.beta/storage/orders/10/checks/FRHIwCr43ZDwTkCeL7H3JtmDwYIEE1aCVGyLs7nn.png");
})->name('dump-download');
