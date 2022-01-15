<?php

namespace App\Repositories;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Helpers\SidoohNotify\SidoohNotify;

class NotificationRepository
{
    public static function sendSMS(array $to, string $message): array
    {
        if (config('services.sidooh.services.notify.enabled', false)) {
            return SidoohNotify::sendSMSNotification($to, $message);
        } else {
            return (new AfricasTalkingApi())->sms($to, $message);
        }
    }
}
