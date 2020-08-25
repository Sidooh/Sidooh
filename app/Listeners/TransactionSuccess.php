<?php

namespace App\Listeners;

use App\Events\TransactionSuccessEvent;
use App\Repositories\EarningRepository;
use Illuminate\Support\Facades\Log;

class TransactionSuccess
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
     * @param TransactionSuccessEvent $event
     * @return void
     */
    public function handle(TransactionSuccessEvent $event)
    {
        //
        Log::info('----------------- Transaction Success');

        $trans = $event->transaction;
        $earnings = $event->totalEarned;

        (new EarningRepository)->calcEarnings($trans, $earnings);
    }
}
