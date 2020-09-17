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
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('devise','Api\DeviceController@addDeviceToken');
});

Route::group(["namespace"=>"ApiClient"],function() {
    //---------------------------- Auth --------------------------------//
    Route::post('register','Auth\AuthController@register');
    Route::post('login','Auth\AuthController@login');

    //---------------------------- Auth social --------------------------------//
    Route::post('auth/{driver}','Auth\Social\SocialController@authSocial');

    //---------------------------- Forget Password --------------------------------//
    Route::post('forget-password','Profile\ProfileController@forgetPassword');

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

        Route::get('/order-requests/{id}','Order\OrderServiceController@showRequests');
        Route::post('/order-request-accept/{id}','Order\OrderServiceController@acceptRequest');
        Route::post('/order-request-decline/{id}','Order\OrderServiceController@declineRequests');
        //---------------------------- Order Food --------------------------------//
        Route::post('food-orders','Order\OrderFoodController@store');
        Route::get('food-orders/{id}','Order\OrderFoodController@show');
        Route::post('food-orders/confirm','Order\OrderFoodController@confirmOrder');
        Route::post('food-orders/done','Order\OrderFoodController@doneOrder');
        Route::post('food-orders/restore','Order\OrderFoodController@restoreOrder');
        Route::post('food-orders/cancel','Order\OrderFoodController@cancelOrder');
        Route::post('food-orders/paid','Order\OrderFoodController@PaidOrder');
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
            Route::get('ratings-prices','Product\FilterController@getRatingsPrices');
            Route::get('/','Product\FilterController@getByFilters');
        });
        //---------------------------- Service  --------------------------------//
        Route::prefix('services')->group(function () {
            Route::get('{type}','Product\ProductController@indexServices');
            Route::get('get/{id}','Product\ProductController@show');
            Route::get('menus/{service_id}/sort/{sort_type}','Product\ProductController@showBySortType');
            Route::get('menus/{service_id}/{category}','Product\ProductController@showByCategory');
            Route::get('categories/{service_id}','Product\ProductController@showServiceCategory');
            Route::get('product/{id}','Product\ProductController@getProductComponent');
            });
        //------------------------------ Feedback ---------------------------------//
        Route::get('feedback','Feedback\FeedbackController@index');
        Route::get('my-feedback','Feedback\FeedbackController@getMyFeedback');
        Route::post('store-company-feedback','Feedback\FeedbackController@storeCompanyFeedback');
        Route::get('get-company-for-feedback','Feedback\FeedbackController@getCompanyForFeedback');
        Route::post('feedback/create ','Feedback\FeedbackController@store');

        //------------------------------ Checkout ---------------------------------//
        Route::post('checkout','Checkout\OrderCheckoutController@checkout');

        //-------------------------------- Query -----------------------------------//
        Route::get('query', 'Query\QueryController@index');

        //--------------------------------- FAQ ------------------------------------//
        Route::get('faq', 'FAQ\FaqController@index');

        //------------------------------- PreOrder ---------------------------------//
        Route::post('answers', 'Order\PreOrderController@store');

    });
});


