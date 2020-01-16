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
        });

    });
});
