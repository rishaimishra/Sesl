<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {

    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');
    Route::post('register-seller', 'Api\AuthController@registerSeller');
    Route::post('forgot-password', 'Api\AuthController@forgotPassword');

    Route::post('reset-password', 'Api\AuthController@resetPassword');

    Route::post('check-otp', 'Api\AuthController@checkOTP');

    Route::group(['middleware' => 'auth:api'], function () {

        Route::post('change-mobile-number', 'Api\AuthController@changeMobileNumber');

        Route::post('resend-otp', 'Api\AuthController@resendOTP');

        Route::post('mobile-verification', 'Api\AuthController@mobileVerification');

        Route::get('/me', 'Api\UserController@getUser');


        //seller
        Route::post('/upload-document', 'Api\SellerDetailController@uploadDocuments');
        Route::get('/check-verify', 'Api\SellerDetailController@checkVerify');
        Route::post('/create-store', 'Api\SellerDetailController@createCategory');
        Route::post('/create-product', 'Api\SellerDetailController@createProduct');




        Route::post('logout', 'Api\AuthController@logout');

        Route::middleware('verified_mobile')->group(function () {
            Route::group(['prefix' => 'me'], function () {

                Route::post('/', 'Api\UserController@store');

            });

            Route::post('update-password', 'Api\AuthController@updatePassword');

            Route::group(['prefix' => 'digital-address'], function () {

                Route::get('/', 'Api\DigitalAddressController@index');
                Route::get('/{id}', 'Api\DigitalAddressController@show');
                Route::post('/', 'Api\DigitalAddressController@store');
                Route::put('/{id}', 'Api\DigitalAddressController@update');
                Route::delete('/{id}', 'Api\DigitalAddressController@destroy');
                Route::post('/search', 'Api\DigitalAddressController@search');
                Route::post('/area_search', 'Api\DigitalAddressController@areaSearch');
                Route::post('/area_by_id', 'Api\DigitalAddressController@areaById');
            });

            Route::group(['prefix' => 'place'], function () {

                Route::get('/category/{id?}', 'Api\PlaceController@getPlaceCategory');
                Route::get('/{id}', 'Api\PlaceController@getPlace');
            });

            Route::group(['prefix' => 'knowledgebase'], function () {

                Route::get('/category/{id?}', 'Api\KnowledgebaseController@getKnowledgebaseCategory');
                Route::get('/{id}', 'Api\KnowledgebaseController@getQuestion');
            });

            Route::group(['prefix' => 'product'], function () {

                Route::get('/category/{id?}', 'Api\ProductController@getProductCategory');
                Route::get('/{id}', 'Api\ProductController@getProducts');
                Route::get('/single/{id}', 'Api\ProductController@getProduct');
            });

            Route::group(['prefix' => 'auto'], function () {

                Route::get('/category/{id?}', 'Api\AutoController@getAutoCategory');
                Route::get('/{id}', 'Api\AutoController@getAutos');
                Route::get('/single/{id}', 'Api\AutoController@getAuto');
                Route::post('setInterested/{auto}', 'Api\AutoController@setInterested');
            });

            Route::group(['prefix' => 'realestate'], function () {

                Route::get('/category/{id?}', 'Api\RealEstateController@getAutoCategory');
                Route::get('/{id}', 'Api\RealEstateController@getProperties');
                Route::get('/single/{id}', 'Api\RealEstateController@getProperty');
                Route::post('setInterested/{realEstate}', 'Api\RealEstateController@setInterested');
            });

            Route::group(['prefix' => 'cart'], function () {

                Route::get('/getCart', 'Api\CartController@getCart');
                Route::post('/addcart', 'Api\CartController@addCart');
                Route::post('/addDigitalAddress', 'Api\CartController@addDigitalAddress');
                Route::post('/updateCart', 'Api\CartController@updateCart');
                Route::post('/deleteItemFromCart', 'Api\CartController@deleteItemFromCart');

            });

            Route::post('/place-order', 'Api\OrderController@placeOrder');
            Route::get('/place-order', 'Api\OrderController@index');
            
            //saved meter apis
            Route::get('/saved-meters', 'Api\SavedMeterController@index');
            Route::get('/edsa-transaction', 'Api\EdsaTransactionController@index');
            Route::post('/add/saved-meter','Api\SavedMeterController@create');
            Route::post('/delete/saved-meter','Api\SavedMeterController@delete');
            Route::post('/add/edsa-transaction','Api\EdsaTransactionController@create');
            
            
            
            //saved dstv recharge cards
            Route::get('/saved-dstv-recharge-cards', 'Api\SavedDstvRechargeCardController@index');
            Route::post('/add/saved-recharge-cards','Api\SavedDstvRechargeCardController@create');
            Route::post('/delete/saved-recharge-cards','Api\SavedDstvRechargeCardController@delete');
            
            
            //saved star recharge cards
            Route::get('/saved-star-recharge-cards', 'Api\SavedStarRechargeCardController@index');
            Route::post('/add/saved-star-recharge-cards','Api\SavedStarRechargeCardController@create');
            Route::post('/delete/saved-star-recharge-cards','Api\SavedStarRechargeCardController@delete');
            
            
            //edsa user verifications
            Route::get('/get-edsa-otp-verify', 'Api\UserController@setEdsaPasswordOTP');
            Route::post('/verify-edsa-otp','Api\UserController@checkUserOtp');
            Route::post('/set-edsa-password','Api\UserController@setEdsaPassword');
            Route::post('/verify-edsa-password','Api\UserController@verifyEdsaPassword');
            
        });
    });

    Route::get('/get-ads', 'Api\AdDetailController@index');
    Route::get('/get-shop-ads','Api\AdDetailController@shopAds');
    Route::get('/get-auto-ads','Api\AdDetailController@autoAds');
    Route::get('/get-realestate-ads','Api\AdDetailController@realestateAds');
    Route::get('/get-utilities-ads','Api\AdDetailController@utilitiesAds');
    Route::post('digital-address/area_search', 'Api\DigitalAddressController@areaSearch');

});
