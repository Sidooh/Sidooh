<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use DrH\Mpesa\Events\QueueTimeoutEvent;

class QueueTimeoutListener
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
     * @param QueueTimeoutEvent $event
     * @return void
     */
    public function handle(QueueTimeoutEvent $event)
    {
        //
        Log::info('------------------------ Queue Timeout ' . now() . ' ---------------------- ');

        Log::info($event->request);
        Log::info($event->initiator);

    }
}
