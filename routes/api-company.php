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


//---------------------------- API for company ------------------------------//

Route::group(["namespace"=>"ApiCompany"],function() {
    Route::post('login','Auth\AuthController@login');

    Route::group(['middleware' => ['auth:api','company']], function () {
        //---------------------------- Auth logout --------------------------------//
        Route::post('logout','Auth\AuthController@logout');
        //---------------------------- Profile  --------------------------------//
        Route::prefix('company-profile')->group(function () {
            Route::get('/','Profile\ProfileCompanyController@getClientProfile');
            Route::post('update','Profile\ProfileCompanyController@updateClientProfile');
            Route::get('get-language', 'Profile\ProfileCompanyController@getLanguage');
            Route::get('get-schedule','Profile\ProfileCompanyController@getSchedule');
            Route::get('get-credit-card','Profile\ProfileCompanyController@getCreditCard');
            Route::post('update-language','Profile\ProfileCompanyController@updateLanguage');
            Route::post('update-schedule','Profile\ProfileCompanyController@updateSchedule');
            Route::post('update-credit-card','Profile\ProfileCompanyController@updateCreditCard');
            //------------------------------ Feedback ---------------------------------//
            Route::get('feedback','Feedback\FeedbackController@index');
            Route::get('my-feedback','Feedback\FeedbackController@getMyFeedback');
            Route::post('feedback/create ','Feedback\FeedbackController@store');
        });

        //------------------------------ Service ---------------------------------//
        Route::post('create-service','Category\ServiceController@create');

        //------------------------------ Suggest category ---------------------------------//

        Route::post('suggest-category','Category\ServiceController@storeSuggestCategory');

        //------------------------------ Geolocation ---------------------------------//
        Route::post('geo','Place\CompanyPlace@store');
        Route::get('geo','Place\CompanyPlace@getCompanyGeo');

        //------------------------------ Service order ---------------------------------//
        Route::get('get-service-order','Order\OrderServiceController@getServiceOrder');
        Route::get('get-service-order-no-geo','Order\OrderServiceController@getAllOrderNoGeo');
        Route::get('get-service-order/{id}','Order\OrderServiceController@getServiceOrderById');
        Route::get('get-service-order-by-filters','Order\OrderServiceController@getServiceOrderByFilters');
        Route::post('done-service-order','Order\OrderFoodController@doneFoodOrder');
        //------------------------------ Food order ----------------------------------------//
        Route::get('get-food-order','Order\OrderFoodController@getFoodOrder');
        Route::get('get-food-order-no-status','Order\OrderFoodController@getOrderWithOutStatus');
        Route::post('take-food-order','Order\OrderFoodController@takeFoodOrder');
        Route::post('in-progress-food-order','Order\OrderFoodController@inProgressFoodOrder');
        Route::post('done-food-order','Order\OrderFoodController@doneFoodOrder');
        Route::get('get-food-order/{id}','Order\OrderFoodController@getOrderById');
        Route::get('get-food-order/{order_id}/{product_id} ','Order\OrderFoodController@getProductInOrderById');
        Route::patch('cancel-food-order/{id}','Order\OrderFoodController@cancelFoodOrder');
        Route::post('cancel-food-order-items/{id}','Order\OrderFoodController@cancelFoodOrderItems');
        //------------------------------ Action over service order ---------------------------------//
        Route::post('take-service-order','Order\ActionServiceOrderController@takeServiceOrder');
        Route::patch('cancel-service-order/{id}','Order\ActionServiceOrderController@cancelServiceOrder');

    });
});
