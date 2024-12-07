<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Nabcellent\Kyanda\Events\KyandaTransactionSuccessEvent;

class KyandaTransactionFailed
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
     * @param KyandaTransactionSuccessEvent $event
     * @return void
     */
    public function handle(KyandaTransactionSuccessEvent $event)
    {
        //
        Log::info('----------------- Kyanda Transaction Failed ');
        Log::error($event->transaction);

    }
}
