<?php

namespace App\Repositories;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Helpers\SidoohNotify\SidoohNotify;

class NotificationRepository
{
    public static function sendSMS(array $to, string $message)
    {
        if (config('services.sidooh.services.notify.enabled', false)) {
            SidoohNotify::sendSMSNotification($to, $message);
        } else {
            (new AfricasTalkingApi())->sms($to, $message);
        }
    }
}
