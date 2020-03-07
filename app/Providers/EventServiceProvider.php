<?php

namespace App\Providers;

use App\Events\AirtimePurchaseFailedEvent;
use App\Events\AirtimePurchaseSuccessEvent;
use App\Events\TransactionSuccessEvent;
use App\Listeners\AirtimePurchaseFailed;
use App\Listeners\AirtimePurchaseSuccess;
use App\Listeners\StkPaymentReceived;
use App\Listeners\TransactionSuccess;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Samerior\MobileMoney\Mpesa\Events\StkPushPaymentSuccessEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        StkPushPaymentSuccessEvent::class => [
            StkPaymentReceived::class,// your listening class
        ],

        AirtimePurchaseSuccessEvent::class => [
            AirtimePurchaseSuccess::class
        ],

        AirtimePurchaseFailedEvent::class => [
            AirtimePurchaseFailed::class
        ],

        TransactionSuccessEvent::class => [
            TransactionSuccess::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
