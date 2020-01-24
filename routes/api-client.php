<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//---------------------------- API for client ------------------------------//

Route::group(["namespace"=>"ApiClient"],function() {

    //---------------------------- Auth --------------------------------//
    Route::post('register','Auth\AuthController@register');
    Route::post('login','Auth\AuthController@login');

    //---------------------------- Auth social --------------------------------//
    Route::post('auth/{driver}','Auth\Social\SocialController@authSocial');

    Route::group(['middleware' => ['auth:api','user']], function () {
        //---------------------------- Auth logout --------------------------------//
        Route::post('logout','Auth\AuthController@logout');
        //---------------------------- Profile  --------------------------------//
        Route::get('profiles','Profile\ProfileController@getUserByToken');
        Route::get('user-profiles-comments','Profile\ProfileController@getProfileComments');
        Route::post('profiles/{id}','Profile\ProfileController@update');
        //---------------------------- Order Service --------------------------------//
        Route::post('orders','Order\OrderServiceController@store');
        Route::get('orders/{id}','Order\OrderServiceController@show');
        Route::post('/orders/confirm','Order\OrderServiceController@confirmOrder');
        Route::post('/orders/restore','Order\OrderServiceController@restoreOrder');
        Route::post('/orders/cancel','Order\OrderServiceController@cancelOrder');
        //---------------------------- Order Food --------------------------------//
        Route::post('food-orders','Order\OrderFoodController@store');
        Route::get('food-orders/{id}','Order\OrderFoodController@show');
        Route::post('food-orders/confirm','Order\OrderFoodController@confirmOrder');
        Route::post('food-orders/restore','Order\OrderFoodController@restoreOrder');
        Route::post('food-orders/cancel','Order\OrderFoodController@cancelOrder');
        //---------------------------- Place --------------------------------//
        Route::get('places','Place\PlaceServiceController@index');
        Route::post('places','Place\PlaceServiceController@store');
        //---------------------------- Credit card --------------------------------//
        Route::post('cards','CreditCard\CardController@store');
        //--------------------------------- Curt -------------------------------//
        Route::resource('cart','Order\CurtController');
        //-----------------------------Filters ------------------------------------//
        Route::prefix('filter')->group(function (){
            Route::get('kitchens','Product\FilterController@getKitchen');
            Route::get('/','Product\FilterController@getByFilters');
        });
        //---------------------------- Service  --------------------------------//
        Route::prefix('services')->group(function () {
            Route::get('{type}','Product\ProductController@indexServices');
            Route::get('get/{id}','Product\ProductController@show');
            Route::get('menus/{service_id}/{category}','Product\ProductController@showByCategory');
            Route::get('categories/{service_id}','Product\ProductController@showServiceCategory');
            Route::get('product/{id}','Product\ProductController@getProductComponent');
            });
        //------------------------------ Feedback ---------------------------------//
        Route::get('feedback','Feedback\FeedbackController@index');
        Route::get('/my-feedback','Feedback\FeedbackController@getMyFeedback');
        Route::post('/feedback/create ','Feedback\FeedbackController@store');

        //------------------------------ Checkout ---------------------------------//
        Route::post('checkout','Checkout\OrderCheckoutController@checkout');
    });
});

