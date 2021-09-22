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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => '/admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    Route::get('/', 'DashboardController@index')->name('index');

    Route::apiResource('users', 'UserController');
    Route::apiResource('accounts', 'AccountController');
    Route::apiResource('transactions', 'TransactionController');
    Route::post('transactions/status/query', 'TransactionController@queryStatus')->name('transactions.status.query');
    Route::apiResource('referrals', 'ReferralController');
    Route::apiResource('earnings', 'EarningController');
    Route::apiResource('vouchers', 'VoucherController');
    Route::apiResource('sub-accounts', 'SubAccountController');
    Route::apiResource('collective-investments', 'CollectiveInvestmentController');
    Route::get('collective-investments/{collectiveInvestment}/sub-investments', 'CollectiveInvestmentController@subInvestments')->name('collective-investments.sub-investments');

    Route::apiResource('sub-investments', 'SubInvestmentController');
    Route::resource('user-notifications', 'UserNotificationController');
    Route::apiResource('subscriptions', 'SubscriptionController');


});
