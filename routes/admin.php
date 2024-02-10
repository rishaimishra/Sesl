<?php

use App\Http\Controllers\Admin\Attribute\AttributeSetController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'auth.', 'namespace' => 'Auth'], function () {

    Route::get('login', 'LoginController@showForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('forgot-password');
    Route::post('forgot-password', 'ForgotPasswordController@sendResetLinkEmail');
    Route::get('reset-password', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::POST('reset-password', 'ResetPasswordController@reset')->name('password.update');

});


//Route::resource('productseller', 'ProductSeller\ProductSellerController')->except('show');

Route::group(['middleware' => 'auth:admin'], function () {

    Route::get('dashboard', 'DashboardController')->name('dashboard');

    Route::group(['prefix' => 'account', 'as' => 'account.', 'namespace' => 'Account'], function () {
        Route::get('reset-password', 'ResetPasswordController')->name('reset-password');
        Route::post('reset-password', 'ResetPasswordController@update')->name('update-password');
        Route::post('updateprofile', 'ResetPasswordController@update')->name('update-profile');
    });


    Route::get('digitl-address/{id}', 'DigitalAddressController@show')->name('digitl-address.show');
    Route::get('digitl-address/', 'DigitalAddressController@index')->name('digitl-address.index');

    Route::group(['prefix' => 'attribute'], function() {

        Route::get('/attribute-groups-by-attribute-set/{id}', 'Attribute\AttributeController@attributeGroupsByAttributeSet');
        Route::resource('attribute', "Attribute\AttributeController")->except('show');

        Route::resource('attribute-set', "Attribute\AttributeSetController")->except('show');
        Route::resource('attribute-group', "Attribute\AttributeGroupController")->except('show');
    });

    Route::resource('user', 'UserController');
    Route::resource('address', 'AddressController');
    Route::resource('address-area', 'AddressAreasController');
    Route::resource('address-section', 'AddressSectionsController');
    
    

    Route::resource('savedmeter', 'SavedMeterController');
    Route::resource('saveddstvrechargecard', 'SavedDstvRechargeCardController');
    Route::resource('edsatransaction','EdsaTransactionController');
    Route::resource('dstvtransaction','DstvTransactionController');
    Route::resource('startransaction','StarTransactionController');
    Route::resource('seller', 'SellerDetailController');
    Route::get('seller-verify/{id}', 'SellerDetailController@verify')->name('seller.verify');

    

    Route::get('system-user/create', 'AdminUserController@showUserForm')->name('system-user.create');
    Route::get('system-user/list', 'AdminUserController@list')->name('system-user.list');
    Route::get('system-user/show/{id}', 'AdminUserController@show')->name('system-user.show');
    Route::post('system-user/update', 'AdminUserController@update')->name('system-user.update');
    Route::get('system-user/delete/{id}', 'AdminUserController@destroy')->name('system-user.delete');
    Route::post('system-user/create', 'AdminUserController@store');

    Route::resource('place-category', 'Place\PlaceCategoryController')->except('show');

    Route::resource('place', 'Place\PlaceController')->except('show');

    Route::resource('auto-category', 'Auto\AutoCategoryController')->except('show');

    Route::resource('auto', 'Auto\AutoController')->except('show');
    Route::group(['prefix' => 'auto','namespace' => 'Auto', 'as' => 'auto.'], function () {
        Route::get('interested-users/{auto}', 'AutoController@interestedUsers')->name('interested.users');
    });

    //Route::resource('realestate-category', 'RealEstate\RealEstateCategoryController')->except('show');
    Route::resource('real-estate-category', 'RealEstate\RealEstateCategoryController')->except('show');

    Route::resource('real-estate', 'RealEstate\RealEstateController')->except('show');

    Route::group(['prefix' => 'real-estate','namespace' => 'RealEstate', 'as' => 'real-estate.'], function () {
        Route::get('interested-users/{realEstate}', 'RealEstateController@interestedUsers')->name('interested.users');
    });

    Route::resource('knowledgebase-category', 'Knowledgebase\KnowledgebaseCategoryController')->except('show');

    Route::resource('question', 'Knowledgebase\QuestionController')->except('show');
    Route::get('question-create-upload','Knowledgebase\QuestionController@createUpload')->name('question.upload');
    Route::post('question-create-upload','Knowledgebase\QuestionController@import')->name('question.import');



    Route::resource('ad-detail', 'AdDetailController');


    Route::resource('product-category', 'Product\ProductCategoryController')->except('show');
    Route::resource('product', 'Product\ProductController')->except('show');


    Route::get('imageDelete/product/{id?}', 'Product\ProductController@imageDelete');
    Route::get('imageDelete/place/{id?}', 'Place\PlaceController@imageDelete');
    Route::get('imageDelete/real-estate/{id?}', 'RealEstate\RealEstateController@imageDelete');
    Route::get('imageDelete/auto/{id?}', 'Auto\AutoController@imageDelete');

    Route::resource('order', 'OrderController');
    Route::resource('order-report', 'OrderReportController');

    Route::resource('auto-report', 'AutoReportController');

    Route::resource('real-estate-report', 'RealEstateReportController');

    Route::resource('setting', 'SettingController');

    Route::get('import', 'Knowledgebase\QuestionController@import')->name('import');;

    Route::get('/section/{id}', 'AddressAreasController@getSection');
    Route::group(['prefix' => 'system/config', 'namespace' => 'Config', 'as' => 'config.'], function () {


        Route::get('sponsor', 'SponsorController')->name("sponsor");
        Route::post('sponsor', 'SponsorController@save');

        Route::get('tax', 'TaxController')->name("tax");
        Route::post('tax', 'TaxController@save');
    });
    Route::group(['middleware' => ['role:admin']], function () {

    });
});
