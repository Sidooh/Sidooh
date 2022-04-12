<?php


namespace App\Repositories;


use App\Events\B2CPaymentFailedEvent;
use App\Events\B2CPaymentSuccessEvent;
use App\Helpers\Sidooh\USSD\USSD;
use App\Models\UssdLog;
use App\Models\UssdUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use MrAtiebatie\Repository;
use Samerior\MobileMoney\Mpesa\Database\Entities\MpesaBulkPaymentResponse;


class UssdRepository
{

    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    public function processRefactored()
    {
//        TODO: Check whether the following three are necessary
        error_reporting(0);
        header('Content-type: text/plain');
        set_time_limit(100);

        //get inputs
        $sessionId = $_REQUEST["sessionId"];
        $serviceCode = $_REQUEST["serviceCode"];
        $phoneNumber = $_REQUEST["phoneNumber"];
        $text = $_REQUEST["text"];   //

        if (empty($phoneNumber)) {
            Log::error("Ussd Phone Number Request is empty");
            return Response::json("Could not process request.", 422);
        }

//        $data = ['phone' => $phoneNumber, 'text' => $text, 'service_code' => $serviceCode, 'session_id' => $sessionId];

        //log USSD request
//        UssdLog::create($data);
        UssdLog::updateOrCreate(
            [
                'phone' => $phoneNumber,
                'session_id' => $sessionId,
            ],
            [
                'text' => $text,
                'service_code' => $serviceCode,
            ]
        );

        $user = UssdUser::wherePhone($phoneNumber)->first();

        if (!$user) {
            Log::info('Ussd user being created.');

            $usr = array();
            $usr['phone'] = $phoneNumber;
            $usr['session'] = 0;
            $usr['progress'] = 0;
            $usr['confirm_from'] = 0;
            $usr['menu_item_id'] = 0;

            $user = UssdUser::create($usr);
        }

        $ussd = new USSD($sessionId, $user);

        if (self::user_is_starting($text)) {
            Log::info('Ussd user is starting.', [$sessionId, $phoneNumber]);
            //lets get the home menu
            //reset user
            self::resetUser($user);

            echo $ussd->processUssd($user, $text);
            exit;
        }

        $result = explode("*", $text);
        if (empty($result)) {
            $message = $text;
        } else {
            end($result);
            // move the internal pointer to the end of the array
            $message = current($result);
        }

        if (count($result) == 1)
            self::resetUser($user);

        error_log($message);
        echo $ussd->processUssd($user, $message);

//        exit;
    }

    public function resetUser($user)
    {
//        Log::info('Reset User.');

        $user->session = 0;
        $user->progress = 0;
        $user->menu_id = 0;
        $user->difficulty_level = 0;
        $user->confirm_from = 0;
        $user->menu_item_id = 0;

        return $user->save();

    }

    public function user_is_starting($text)
    {
//        Log::info('User is starting?');

        if (strlen($text) > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * @return MpesaBulkPaymentResponse|\Illuminate\Database\Eloquent\Model
     */
    private function handleB2cResult()
    {
        $data = request('Result');

        //check if data is an array
        if (!is_array($data)) {
            $data->toArray();
        }

        $common = [
            'ResultType', 'ResultCode', 'ResultDesc', 'OriginatorConversationID', 'ConversationID', 'TransactionID'
        ];
        $seek = ['OriginatorConversationID' => $data['OriginatorConversationID']];
        /** @var MpesaBulkPaymentResponse $response */
        $response = null;
        if ($data['ResultCode'] !== 0) {
            $response = MpesaBulkPaymentResponse::updateOrCreate($seek, Arr::only($data, $common));
            event(new B2CPaymentFailedEvent($response, $data));
            return $response;
        }
        $resultParameter = $data['ResultParameters'];

        $data['ResultParameters'] = json_encode($resultParameter);
        $response = MpesaBulkPaymentResponse::updateOrCreate($seek, Arr::except($data, ['ReferenceData', 'ResultParameters']));
        $this->saveResultParams($resultParameter, $response);
        event(new B2CPaymentSuccessEvent($response, $data));
        return $response;
    }

    private function saveResultParams(array $params, MpesaBulkPaymentResponse $response): \Illuminate\Database\Eloquent\Model
    {
        $params_payload = $params['ResultParameter'];
        $new_params = Arr::pluck($params_payload, 'Value', 'Key');

//        TODO: Added this for date conversion otherwise throws db error
        $new_params['TransactionCompletedDateTime'] = Carbon::createFromFormat('d.m.Y H:i:s', $new_params['TransactionCompletedDateTime'], 'Africa/Nairobi');

        return $response->data()->create($new_params);
    }

    /**
     * @param string|null $initiator
     * @return MpesaBulkPaymentResponse|void
     */
    public function handleResult($initiator = null)
    {
        if ($initiator === 'b2c') {
            return $this->handleB2cResult();
        }
        return;
    }

}
