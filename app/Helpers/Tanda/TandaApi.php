<?php

namespace App\Helpers\Tanda;

use App\Helpers\SidoohNotify\EventTypes;
use App\Models\Transaction;
use App\Repositories\NotificationRepository;
use DrH\Tanda\Exceptions\TandaException;
use DrH\Tanda\Facades\Utility;
use DrH\Tanda\Models\TandaRequest;
use Illuminate\Support\Facades\Log;

class TandaApi
{
    public static function airtime(Transaction $transaction, array $array): void
    {
        try {
            $request = Utility::airtimePurchase($array['phone'], $array['amount'], $transaction->id);
            self::handleRequestResponse($request);
        } catch (TandaException $e) {
            Log::error("TandaError: " . $e->getMessage(), [$transaction]);
        }
    }

    public static function bill(Transaction $transaction, array $array, string $provider): void
    {
        try {
            $request = Utility::billPayment($array['account'], $array['amount'], $provider, $transaction->id);
            self::handleRequestResponse($request);
        } catch (TandaException $e) {
            Log::error("TandaError: " . $e->getMessage(), [$transaction]);
        }
    }

    private static function handleRequestResponse(TandaRequest $request)
    {
        if ($request->status == 2) {
            try {
                $message = "TN_ERROR-{$request->relation->id}\n";
                $message .= "{$request->provider} - {$request->destination}\n";
                $message .= "{$request->message}\n";
                $message .= `{$request->created_at->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"))}`;

                NotificationRepository::sendSMS(
                    ['254714611696', '254711414987', '254721309253'],
                    $message,
                    EventTypes::ERROR_ALERT
                );
                Log::info("Tanda Airtime/Utility Failure SMS Sent");
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
