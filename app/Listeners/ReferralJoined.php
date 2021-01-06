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

        $message = "Well Done! Your referral {$refPhone} has ";
        $message .= "successfully accessed Sidooh using your referral code. ";
        $message .= "Show them how to purchase airtime from Sidooh. ";
        $message .= "This will unlock your referral earnings. ";
        $message .= "The more friends you refer to Sidooh, the more you earn.";

        (new AfricasTalkingApi())->sms($accPhone, $message);
    }
}
