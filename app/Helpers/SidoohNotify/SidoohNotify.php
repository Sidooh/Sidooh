<?php

namespace App\Helpers\SidoohNotify;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SidoohNotify
{

    public static function sendSMSNotification(array $to, string $message, string $eventType): array
    {
        Log::info('----------------- Sidooh SMS Notification', [
            'eventType' => $eventType,
            'to' => $to,
            'message' => $message
        ]);

        $url = env('SIDOOH_NOTIFY_URL');

        $response = Http::retry(3)->post(
            $url,
            [
                "channel" => "sms",
                "event_type" => $eventType,
                "destination" => $to,
                "content" => $message
            ]
        );

        Log::info('----------------- Sidooh SMS Notification sent', [
            'id' => $response->json()['id']
        ]);

        return $response->json();

    }

}
