<?php

namespace App\Repositories;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Helpers\SidoohNotify\SidoohNotify;

class NotificationRepository
{
    public static function sendSMS(array $to, string $message, string $eventType): array
    {
        if (config('services.sidooh.services.notify.enabled', true)) {
            return SidoohNotify::sendSMSNotification($to, $message, $eventType);
        } else {
            return (new AfricasTalkingApi())->sms($to, $message);
        }
    }
}
