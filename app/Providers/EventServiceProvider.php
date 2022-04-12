<?php

namespace App\Providers;

use App\Events\AirtimePurchaseFailedEvent;
use App\Events\AirtimePurchaseSuccessEvent;
use App\Events\B2CPaymentFailedEvent;
use App\Events\B2CPaymentSuccessEvent;
use App\Events\MerchantPurchaseEvent;
use App\Events\ReferralJoinedEvent;
use App\Events\SubscriptionPurchaseEvent;
use App\Events\TransactionSuccessEvent;
use App\Events\VoucherPurchaseEvent;
use App\Listeners\AirtimePurchaseFailed;
use App\Listeners\AirtimePurchaseSuccess;
use App\Listeners\B2CPaymentFailed;
use App\Listeners\B2CPaymentSent;
use App\Listeners\C2bPaymentConfirmation;
use App\Listeners\KyandaRequest;
use App\Listeners\KyandaTransactionFailed;
use App\Listeners\KyandaTransactionSuccess;
use App\Listeners\MerchantPurchaseSuccess;
use App\Listeners\QueueTimeoutListener;
use App\Listeners\ReferralJoined;
use App\Listeners\StkPaymentFailed;
use App\Listeners\StkPaymentReceived;
use App\Listeners\SubscriptionPurchaseSuccess;
use App\Listeners\TandaRequestFailed;
use App\Listeners\TandaRequestSuccess;
use App\Listeners\TransactionSuccess;
use App\Listeners\VoucherPurchaseSuccess;
use DrH\Mpesa\Events\C2bConfirmationEvent;
use DrH\Mpesa\Events\QueueTimeoutEvent;
use DrH\Mpesa\Events\StkPushPaymentFailedEvent;
use DrH\Mpesa\Events\StkPushPaymentSuccessEvent;
use DrH\Tanda\Events\TandaRequestFailedEvent;
use DrH\Tanda\Events\TandaRequestSuccessEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Nabcellent\Kyanda\Events\KyandaRequestEvent;
use Nabcellent\Kyanda\Events\KyandaTransactionFailedEvent;
use Nabcellent\Kyanda\Events\KyandaTransactionSuccessEvent;

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
            StkPaymentReceived::class,
        ],

        StkPushPaymentFailedEvent::class => [
            StkPaymentFailed::class,
        ],

        B2CPaymentSuccessEvent::class => [
            B2CPaymentSent::class
        ],

        B2CPaymentFailedEvent::class => [
            B2CPaymentFailed::class
        ],

        QueueTimeoutEvent::class => [
            QueueTimeoutListener::class
        ],

        C2bConfirmationEvent::class => [
            C2bPaymentConfirmation::class
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

        KyandaRequestEvent::class => [
            KyandaRequest::class
        ],

        KyandaTransactionSuccessEvent::class => [
            KyandaTransactionSuccess::class
        ],

        KyandaTransactionFailedEvent::class => [
            KyandaTransactionFailed::class
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
}
