<?php


namespace App\Repositories;


use App\Helpers\Sidooh\USSD\USSD;
use App\Models\UssdLog;
use App\Models\UssdUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use MrAtiebatie\Repository;

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
        error_reporting(0);
        header('Content-type: text/plain');
        set_time_limit(100);

        //get inputs
        $sessionId = $_REQUEST["sessionId"];
        $serviceCode = $_REQUEST["serviceCode"];
        $phoneNumber = $_REQUEST["phoneNumber"];
        $text = $_REQUEST["text"];   //

        $data = ['phone' => $phoneNumber, 'text' => $text, 'service_code' => $serviceCode, 'session_id' => $sessionId];

        //log USSD request
        UssdLog::create($data);

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
            Log::info('Ussd user is starting.');
            //lets get the home menu
            //reset user
            self::resetUser($user);

            echo $ussd->process($user, $text);
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
        echo $ussd->process($user, $message);

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

}
