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

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CollectiveInvestmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EarningController;
use App\Http\Controllers\Admin\ReferralController;
use App\Http\Controllers\Admin\SubAccountController;
use App\Http\Controllers\Admin\SubInvestmentController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserNotificationController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('/admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/statistics', [DashboardController::class, 'statistics'])->name('statistics');

    Route::resources([
        'user-notifications' => UserNotificationController::class,
    ]);

    Route::resources([
        'users' => UserController::class,
        'accounts' => AccountController::class,
        'transactions' => TransactionController::class,
        'referrals' => ReferralController::class,
        'earnings' => EarningController::class,
        'vouchers' => VoucherController::class,
        'sub-accounts' => SubAccountController::class,
        'collective-investments' => CollectiveInvestmentController::class,
        'sub-investments' => SubInvestmentController::class,
        'subscriptions' => SubscriptionController::class,
    ]);

    Route::post('accounts/{account}/voucher/topup', [AccountController::class, 'topupVoucher'])
        ->name('accounts.voucher.topup');

    Route::post('transactions/status/query', [TransactionController::class, 'queryStatus'])
        ->name('transactions.status.query');
    Route::post('transactions/{transaction}/refund', [TransactionController::class, 'refund'])
        ->name('transactions.refund');
    Route::post('transactions/{transaction}/mark-complete', [TransactionController::class, 'markComplete'])->name(
        'transactions.status.mark_complete');

    Route::post('transactions/request/status/query', [TransactionController::class, 'queryRequestStatus'])
        ->name('transactions.request.status.query');

    Route::post('payments/{payment}/mark-complete', [TransactionController::class, 'markPaymentComplete'])
        ->name('transactions.payments.status.mark_payment_complete');
    Route::post('transactions/{transaction}/mark-both-complete', [TransactionController::class, 'markBothComplete'])
        ->name('transactions.status.mark_both_complete');

    Route::get('collective-investments/{collectiveInvestment}/sub-investments', [
        CollectiveInvestmentController::class,
        'subInvestments'
    ])->name('collective-investments.sub-investments');
});
