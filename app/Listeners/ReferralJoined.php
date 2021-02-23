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

        $message = "Congratulations! {$refPhone} has ";
        $message .= "successfully accessed Sidooh using your invite code. ";
        $message .= "Show them how to buy airtime from Sidooh so as to unlock your earnings. ";
        $message .= "The more friends you invite to Sidooh, the more you earn.";

        (new AfricasTalkingApi())->sms($accPhone, $message);
    }
}
