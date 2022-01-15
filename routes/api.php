<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
//    Route::post('change-password', 'ChangePasswordController@changePassword')->name('auth.change_password');
    Route::apiResource('accounts', 'AccountController', ['only' => ['index', 'store', 'show']]);
    Route::get('accounts/{account}/referrer', 'AccountController@referrer')->name('accounts.referrer');
    Route::get('accounts/{account}/referrals', 'AccountController@referrals')->name('accounts.referrals');
    Route::get('accounts/{account}/subscriptions', 'AccountController@subscriptions')->name('accounts.subscriptions');
    Route::get('accounts/{account}/vouchers', 'AccountController@vouchers')->name('accounts.vouchers');
    Route::get('accounts/{account}/earnings', 'AccountController@earnings')->name('accounts.earnings');
    Route::get('accounts/{account}/reports/earnings', 'AccountController@earningsReport')->name('accounts.reports.earnings');

    Route::apiResource('transactions', 'TransactionController', ['only' => ['index', 'store', 'show']]);

    Route::apiResource('payments', 'PaymentController', ['only' => ['index', 'store', 'show']]);

    Route::apiResource('referrals', 'ReferralController', ['only' => ['index', 'store']]);
    Route::get('referrals/{phone}', 'ReferralController@byPhone')->name('referrals.byPhone');

    Route::apiResource('subscriptions', 'SubscriptionController', ['only' => ['index', 'store', 'show', 'deactivate']]);
    Route::apiResource('vouchers', 'VoucherController', ['only' => ['index', 'store', 'show']]);
    Route::apiResource('merchants', 'MerchantController', ['only' => ['index', 'store', 'show']]);


    Route::post('ussd2', 'UssdController@index')->name('ussd');

//    TEST USSD V2
    Route::post('ussd', 'UssdController@ussd')->name('ussd2');

    Route::apiResource('ussd_users', 'UssdUserController', ['only' => ['index', 'store', 'show']]);
    Route::apiResource('ussd_menus', 'UssdMenuController', ['only' => ['index', 'store', 'show']]);
    Route::apiResource('ussd_menu_items', 'UssdMenuItemController', ['only' => ['index', 'store', 'show']]);
    Route::apiResource('ussd_responses', 'UssdResponseController', ['only' => ['index', 'store', 'show']]);
    Route::apiResource('ussd_logs', 'UssdLogController', ['only' => ['index', 'store', 'show']]);

    Route::post('payments/mpesa/stk', 'TransactionController@mpesaStkPush')->name('payments.mpesa.stk');
    Route::post('payments/mpesa/stk/callback', 'TransactionController@mpesaStkPushCallback')->name('payments.mpesa.stk.callback');

    Route::post('products/airtime', 'ProductController@airtime')->name('products.airtime');
    Route::post('products/airtime/status/callback', 'ProductController@airtimeStatusCallback')->name('products.airtime.status.callback');

    Route::post('sms/callback', 'ProductController@smsCallback')->name('sms.callback');

    Route::post('b2b/test', 'PaymentController@b2b')->name('b2b.test');

    Route::get('investment/interest/calculate', 'AccountController@calculateInterest')->name('investments.interest.calculate');
    Route::get('interest', 'CollectiveInvestmentController@storeRate')->name('investments.rate.store');
    Route::get('investment/interest/allocate', 'AccountController@allocateInterest')->name('investments.interest.allocate');

    Route::get('jobs/subscriptions/deactivate', 'SubscriptionController@deactivate')->name('subscriptions.deactivate');

//    TODO: Refactor into own service controller?
//    TEST SERVICES
    Route::post('services/test/sms', 'UssdController@sms')->name('services.test.sms');
    Route::post('services/test/airtime', 'UssdController@airtime')->name('services.test.airtime');
    Route::get('services/test/transaction', 'UssdController@transaction')->name('services.test.transaction');
    Route::post('services/test/stk', 'UssdController@stk')->name('services.test.stk');
    Route::post('services/test/b2c', 'UssdController@b2c')->name('services.test.b2c');
    Route::post('services/sms/bulk', 'UssdController@sms')->name('services.test.sms.bulk');

    Route::post('testb2c', 'UssdController@test');

//    TODO: Remove this and reset back once Samerior update library
    Route::post('/payments/callbacks/result/{section?}', 'UssdController@b2cResult');

    Route::post('settings/provider/utilities/{provider}', 'UssdController@setUtilitiesProvider');
    Route::get('settings/provider/utilities', 'UssdController@getUtilitiesProvider');

    Route::get('settings/redis', 'UssdController@getRedisStatus');
    Route::post('settings/utilities', 'UssdController@enableUtilities');
    Route::get('settings/utilities', 'UssdController@getUtilitiesStatus');
    Route::post('settings/sms', 'UssdController@enableSmsProvider');
    Route::get('settings/sms', 'UssdController@getSmsProviderStatus');


    Route::get('payments/mpesa/status/query', 'TransactionController@queryMpesaStatus')->name('payments.mpesa.status.query');
    Route::get('kyanda/status/query', 'TransactionController@queryKyandaStatus')->name('kyanda.status.query');

});


