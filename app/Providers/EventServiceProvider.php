<?php

namespace App\Providers;

use App\Events\AirtimePurchaseFailedEvent;
use App\Events\AirtimePurchaseSuccessEvent;
use App\Events\MerchantPurchaseEvent;
use App\Events\ReferralJoinedEvent;
use App\Events\SubscriptionPurchaseEvent;
use App\Events\TransactionSuccessEvent;
use App\Events\VoucherPurchaseEvent;
use App\Listeners\AirtimePurchaseFailed;
use App\Listeners\AirtimePurchaseSuccess;
use App\Listeners\B2CPaymentFailed;
use App\Listeners\B2CPaymentSent;
use App\Listeners\MerchantPurchaseSuccess;
use App\Listeners\QueueTimeoutListener;
use App\Listeners\ReferralJoined;
use App\Listeners\StkPaymentFailed;
use App\Listeners\StkPaymentReceived;
use App\Listeners\SubscriptionPurchaseSuccess;
use App\Listeners\TransactionSuccess;
use App\Listeners\VoucherPurchaseSuccess;
use DrH\Mpesa\Events\B2cPaymentFailedEvent;
use DrH\Mpesa\Events\B2cPaymentSuccessEvent;
use DrH\Mpesa\Events\QueueTimeoutEvent;
use DrH\Mpesa\Events\StkPushPaymentFailedEvent;
use DrH\Mpesa\Events\StkPushPaymentSuccessEvent;
use DrH\Tanda\Events\TandaRequestFailedEvent;
use DrH\Tanda\Events\TandaRequestSuccessEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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

        StkPushPaymentFailedEvent::class => [
            StkPaymentFailed::class, //your listening classs
        ],

        B2cPaymentSuccessEvent::class => [
            B2CPaymentSent::class
        ],

        B2cPaymentFailedEvent::class => [
            B2CPaymentFailed::class
        ],

        QueueTimeoutEvent::class => [
            QueueTimeoutListener::class
        ],

        AirtimePurchaseSuccessEvent::class => [
            AirtimePurchaseSuccess::class
        ],

        AirtimePurchaseFailedEvent::class => [
            AirtimePurchaseFailed::class
        ],

        TransactionSuccessEvent::class => [
            TransactionSuccess::class
        ],

        ReferralJoinedEvent::class => [
            ReferralJoined::class
        ],

        VoucherPurchaseEvent::class => [
            VoucherPurchaseSuccess::class
        ],

        MerchantPurchaseEvent::class => [
            MerchantPurchaseSuccess::class
        ],

        SubscriptionPurchaseEvent::class => [
            SubscriptionPurchaseSuccess::class
        ],

        TandaRequestSuccessEvent::class => [
            TandaRequestSuccess::class
        ],

        TandaRequestFailedEvent::class => [
            TandaRequestFailed::class
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

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool {
        return true;
    }
}
