<?php

namespace App\Helpers\SidoohNotify;

use Illuminate\Support\Facades\Http;

class SidoohNotify
{

    public static function sendSMSNotification(array $to, string $message): void
    {
        $url = config('services.sidooh.services.notify.url');

        Http::retry(3)->post(
            $url,
            [
                "channel" => "sms",
                "destination" => $to,
                "content" => $message
            ]
        );
    }

}
