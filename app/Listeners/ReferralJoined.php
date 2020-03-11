<?php

namespace App\Listeners;

use App\Events\ReferralJoinedEvent;
use App\Helpers\AfricasTalking\AfricasTalkingApi;

class ReferralJoined
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ReferralJoinedEvent $event
     * @return void
     */
    public function handle(ReferralJoinedEvent $event)
    {
        //
        $accPhone = $event->referral->account->phone;
        $refPhone = $event->referral->referee_phone;

        $message = "Congratulations! Your referral {$refPhone} has ";
        $message .= "successfully registered on Sidooh using your ";
        $message .= "referral code. Show them how to purchase ";
        $message .= "airtime (or anything else available) on Sidooh. ";
        $message .= "This will unlock your referral earnings. The more ";
        $message .= "friends you refer to Sidooh, the more you earn.";

        (new AfricasTalkingApi())->sms($accPhone, $message);
    }
}
