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

    Route::group(['middleware' => 'auth:api'], function () {
        //---------------------------- Auth logout --------------------------------//
        Route::post('logout','Auth\AuthController@logout');
        //---------------------------- Profile  --------------------------------//
        Route::get('company-profile','Profile\ProfileCompanyController@getClientProfile');
        Route::post('company-profile/update','Profile\ProfileCompanyController@updateClientProfile');
        Route::get('company-profile/get-language',
                                                    'Profile\ProfileCompanyController@getLanguage');
        Route::post('company/company-profile/update-language',
                                                    'Profile\ProfileCompanyController@updateLanguage');

    });
});
