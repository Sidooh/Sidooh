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

use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});
//middleware(['auth', 'verified'])->
Route::group([], function () {
//    'middleware' => 'role:admin',
    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
