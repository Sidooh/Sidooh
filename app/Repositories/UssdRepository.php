<?php


namespace App\Repositories;


use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Helpers\Sidooh\Airtime;
use App\Model\User;
use App\Models\UssdLog;
use App\Models\UssdLogs;
use App\Models\UssdMenu;
use App\Models\UssdMenuItem;
use App\Models\UssdResponse;
use App\Models\UssdUser;
use App\Models\UssdUsers;
use Illuminate\Support\Facades\Log;
use MrAtiebatie\Repository;

class UssdRepository
{

    use Repository;

    /**
     * The model being queried.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
//        $this->model = app(Account::class);
    }

    public function processAirtimeUSSD()
    {
        $sessionId = $_REQUEST["sessionId"];
        $serviceCode = $_REQUEST["serviceCode"];
        $networkCode = $_REQUEST["networkCode"];
        $phoneNumber = $_REQUEST["phoneNumber"];
        $text = $_REQUEST["text"];

        if ($text == "") {
            // This is the first request. Note how we start the response with CON
            $response = "CON Welcome to Sidooh. What would you like to do?\n";
            $response .= "1. Buy Airtime \n";
            $response .= "2. Pay \n";
            $response .= "3. Save \n";
            $response .= "4. Refer \n";
            $response .= "5. Check My Account";

        }

//        $textArr = $this->parse_text($text);
//
//        switch ($textArr[0]) {
//            case "1":
//                $response = Airtime::ussdProcessor($phoneNumber, count($textArr), $textArr);
//                break;
//
//            default:
//                $response = "CON Welcome to Sidooh. What would you like to do?\n";
//                $response .= "1. Buy Airtime \n";
//                $response .= "2. Pay \n";
//                $response .= "3. Save \n";
//                $response .= "4. Refer \n";
//                $response .= "5. Check My Account";
//        }

        else if ($text == "1") {

            // Business logic for first level response
            $response = "CON Buy airtime for: \n";
            $response .= "1. Self ($phoneNumber) \n";
            $response .= "2. Other Number\n\n";

        } else if ($text == "2") {
            $response = "END Coming soon...";

        } else if ($text == "1*1") {
            $response = "CON Enter amount: \n(Min: Ksh 5. Max: Ksh 10,000) \n\n";

        } else if ($text == "1*2") {

            $response = "CON Enter phone number \n\n";

        } else if (count($this->parse_text($text)) == 3 && $this->parse_text($text)[1] == 1) {
            $amount = $this->parse_text($text)[2];

            $response = "CON Buy Ksh $amount airtime for $phoneNumber using: \n";
            $response .= "1. MPESA \n";
            $response .= "2. Sidooh Points \n";
            $response .= "3. Sidooh Bonus \n";
            $response .= "4. Other \n\n";

        } else if (count($this->parse_text($text)) == 3 && $this->parse_text($text)[1] == 2) {

            $response = "CON Enter amount: \n(Min: Ksh 5. Max: Ksh 10,000) \n\n";

        } else if (count($this->parse_text($text)) == 4 && $this->parse_text($text)[1] == 2) {

            $amount = $this->parse_text($text)[3];
            $phoneNumber = $this->parse_text($text)[2];

            $response = "CON Buy Ksh $amount airtime for $phoneNumber using: \n";
            $response .= "1. MPESA \n";
            $response .= "2. Sidooh Points \n";
            $response .= "3. Sidooh Bonus \n";
            $response .= "4. Other \n\n";

        } else if (count($this->parse_text($text)) == 4 && $this->parse_text($text)[3] == 1) {
            $amount = $this->parse_text($text)[2];

            $response = "CON Ksh $amount airtime for $phoneNumber will be deducted from your MPESA\n";
            $response .= "1. Accept \n";
            $response .= "2. Cancel \n\n";

        } else if (count($this->parse_text($text)) == 5 && $this->parse_text($text)[4] == 1) {
            $amount = $this->parse_text($text)[3];
            $phoneNumber = $this->parse_text($text)[2];

            $response = "CON Ksh $amount airtime for $phoneNumber will be deducted from your MPESA\n";
            $response .= "1. Accept \n";
            $response .= "2. Cancel \n\n";

        } else if (count($this->parse_text($text)) == 5 && $this->parse_text($text)[4] == 1) {
            $amount = $this->parse_text($text)[2];

            (new Airtime($amount, $phoneNumber))->purchase();

            $response = "END Your request has been received and is being processed. You will receive a confirmation SMS shortly. \nThank you.";

        } else if (count($this->parse_text($text)) == 6 && $this->parse_text($text)[5] == 1) {
            $amount = $this->parse_text($text)[3];
            $phone = $this->parse_text($text)[2];

            (new Airtime($amount, $phoneNumber))->purchase($phone);

            $response = "END Your request has been received and is being processed. You will receive a confirmation SMS shortly. \nThank you.";
        } else if ($text == "4") {
            $response = "CON Enter number to refer";

        } else if (count($this->parse_text($text)) == 2 && $this->parse_text($text)[0] == 4) {
            $phone = $this->parse_text($text)[1];

            (new ReferralRepository())->store([
                'phone' => $phoneNumber,
                'referee_phone' => $phone
            ]);

            $message = "You have been referred by {$phoneNumber} on " . date('d/m/Y') . ". Dial *sss# to start buying airtime seamlessly. \n\nSidooh, Makes You Money!";

            (new AfricasTalkingApi())->sms($phone, $message);

            $message = "You have just referred {$phone}. Tell them to Dial *sss# to start buying airtime seamlessly. \n\nSidooh, Makes You Money!";

            (new AfricasTalkingApi())->sms($phoneNumber, $message);

            $response = "END We have sent $phone a message. You will receive a message soon too. \n\n";

        }


        if (count($this->parse_text($text)) > 1 && count($this->parse_text($text)) < 5) {
            $response .= "0. Back \n";
            $response .= "00. Home";
        }

// Echo the response back to the API
        header('Content-type: text/plain');
        echo $response;
    }

    public function parse_text($text)
    {
        return explode('*', $text);
    }


    public function process()
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
//        print_r($data);
//        exit;
        //log USSD request
        UssdLog::create($data);

        //verify that the user exists
        $no = substr($phoneNumber, -9);

        $user = UssdUser::where('phone', "0" . $no)->orWhere('phone', "254" . $no)->first();

        if (!$user) {
            Log::info('Ussd user being created.');
            //if user phone doesn't exist, we check out if they have been registered to mifos
            $usr = array();
            $usr['phone'] = "0" . $no;
            $usr['session'] = 0;
            $usr['progress'] = 0;
            $usr['confirm_from'] = 0;
            $usr['menu_item_id'] = 0;

            $user = UssdUser::create($usr);
        }

        if (self::user_is_starting($text)) {
            Log::info('Ussd user is starting.');
            //lets get the home menu
            //reset user
            self::resetUser($user);
            //user authentication
            $message = '';

            $response = self::getMenuAndItems($user, 1);

            //get the home menu
            Log::info('Ussd user is starting: ' . $response . $user);
            self::sendResponse($response, 1, $user);
        } else {
            Log::info('Ussd user not starting.');

            //message is the latest stuff
            $result = explode("*", $text);
            if (empty($result)) {
                $message = $text;
            } else {
                end($result);
                // move the internal pointer to the end of the array
                $message = current($result);
            }

            Log::info('Ussd user session switching...');
            switch ($user->session) {

                case 0 :
                    Log::info(' -- case 0.');
                    //neutral user
                    break;
                case 1 :
                    Log::info(' -- case 1.');
                    $response = self::continueUssdMenuProcess($user, $message);
                    //echo "Main Menu";
                    break;
                case 2 :
                    Log::info(' -- case 2.');
                    //confirm USSD Process
                    $response = self::confirmUssdProcess($user, $message);
                    break;
                case 3 :
                    Log::info(' -- case 3.');
                    //Go back menu
                    $response = self::confirmGoBack($user, $message);
                    break;
                case 4 :
                    Log::info(' -- case 4.');
                    //Go back menu
                    $response = self::confirmGoBack($user, $message);
                    break;
                default:
                    Log::info(' -- case default.');
                    break;
            }

            Log::info(' -- no switch');
            self::sendResponse($response, 1, $user);
        }
    }

    //confirm go back
    public function confirmGoBack($user, $message)
    {
        Log::info('Confirm go back.');

        if (self::validationVariations($message, 1, "yes")) {
            Log::info('Validated variations. resetting user.');
            //go back to the main menu
            self::resetUser($user);

            $user->menu_id = 2;
            $user->session = 1;
            $user->progress = 1;
            $user->save();
            //get home menu
            $menu = UssdMenu::find(2);
            $menu_items = self::getMenuItems($menu->id);
            $i = 1;
            $response = $menu->title . PHP_EOL;
            foreach ($menu_items as $key => $value) {
                $response = $response . $i . ": " . $value->description . PHP_EOL;
                $i++;
            }
            self::sendResponse($response, 1, $user);
            exit;

        } elseif (self::validationVariations($message, 2, "no")) {
            Log::info('Validated variations.');
            $response = "Thank you for using our service";
            self::sendResponse($response, 3, $user);

        } else {
            Log::info('Not validated variations.');
            $response = '';
            self::sendResponse($response, 2, $user);
            exit;
        }

    }

    //confirmUssdProcess
    public function confirmUssdProcess($user, $message)
    {
        Log::info('Confirm Ussd Process.');

        $menu = UssdMenu::find($user->menu_id);
        if (self::validationVariations($message, 1, "yes")) {
            //if confirmed
            Log::info('Validated variations.');

            if (self::postUssdConfirmationProcess($user)) {
                Log::info('Confirmed post ussd.');
                $response = $menu->confirmation_message;
            } else {
                Log::info('Failed confirming post ussd.');
                $response = "We had a problem processing your request. Please contact Watu Credit Customer Care on 0790 000 999";
            }

            Log::info(' -- resetting user.');
            self::resetUser($user);
            self::sendResponse($response, 2, $user);

        } elseif (self::validationVariations($message, 2, "no")) {
            Log::info('Validated variations.');
            $response = self::nextMenuSwitch($user, $menu);
            return $response;

        } else {
            Log::info('Not validated variations.');
            //not confirmed
            $response = "We could not understand your response";
            //restart the process
            $output = self::confirmBatch($user, $menu);

            $response = $response . PHP_EOL . $output;
            return $response;
        }


    }

    //post ussd confirmation, define your processes

    public function postUssdConfirmationProcess($user)
    {
        Log::info('Post Ussd confirmation process. user confirm from switching.');
        switch ($user->confirm_from) {
            case 1:
                Log::info(' -- case 1');
                $no = substr($user->phone, -9);

                $data['email'] = "0" . $no . "@sidooh.com";

                User::create($data);
                return true;
                break;

            default :
                Log::info(' -- case default');
                return true;
                break;
        }

    }


    //confirm batch
    public function confirmBatch($user, $menu)
    {
        Log::info('Confirm batch.');
        //confirm this stuff
        $menu_items = self::getMenuItems($user->menu_id);

        $confirmation = "Confirm: " . $menu->title;
        $amount = 0;
        foreach ($menu_items as $key => $value) {

            $response = UssdResponse::whereUserIdAndMenuIdAndMenuItemId($user->id, $user->menu_id, $value->id)->orderBy('id', 'DESC')->first();

            $confirmation = $confirmation . PHP_EOL . $value->confirmation_phrase . ": " . $response->response;
            $amount = $response->response;
        }
        $response = $confirmation . PHP_EOL . "1. Yes" . PHP_EOL . "2. No";

        $user->session = 2;
        $user->confirm_from = $user->menu_id;
        $user->save();

        return $response;
    }


    //continue USSD Menu Progress

    public function continueUssdMenuProcess($user, $message)
    {
        Log::info('Continue ussd menu process.');

        $menu = UssdMenu::find($user->menu_id);

        Log::info('Switching menu type.');
        //check the user menu
        switch ($menu->type) {
            case 0:
                Log::info(' -- case 0.');
                //authentication mini app

                break;
            case 1:
                Log::info(' -- case 1.');
                //continue to another menu

//                self::airtimeMiniApp($user, $menu);
                $response = self::continueUssdMenu($user, $message, $menu);
                break;
            case 2:
                Log::info(' -- case 2.');
                //continue to a processs
                $response = self::continueSingleProcess($user, $message, $menu);
                break;
            case 3:
                Log::info(' -- case 3.');
                //airtime mini app
                //
                self::airtimeMiniApp($user, $menu);
//                self::infoMiniApp($user, $menu);
                break;
            default :
                Log::info(' -- case default.');
                self::resetUser($user);
                $response = "An error occurred";
                break;
        }

        return $response;

    }

    public function airtimeMiniApp($user, $menu)
    {
        Log::info('airtimeMiniApp.');

//        echo "airtimeMiniApp based on menu_id";
//        exit;
        Log::info('Switching menu id.');
        switch ($menu->id) {
            case 1:
                Log::info(' -- case 3.');
                //get the loan balance

                $amount = 50;
                $phone = $user->phone;
                $response = "Buy { $amount } airtime for { $phone } using: ";

                self::sendResponse($response, 2, $user);

                break;
            case 4:
                Log::info(' -- case 4.');
                //get the loan balance

                break;
            case 5:
                Log::info(' -- case 5.');
                break;
            case 6:
                Log::info(' -- case 6.');
            default :
                Log::info(' -- case default.');
                $response = $menu->confirmation_message;

//                $notify = new NotifyController();
                //$notify->sendSms($user->phone_no,$response);
                //self::resetUser($user);
                self::sendResponse($response, 2, $user);

                break;
        }

    }

    //info mini app

    public function infoMiniApp($user, $menu)
    {

        Log::info('infoMiniApp.');

//        echo "infoMiniApp based on menu_id";
//        exit;

        Log::info('Switching menu id.');
        switch ($menu->id) {
            case 4:
                Log::info(' -- case 4.');
                //get the loan balance

                break;
            case 5:
                Log::info(' -- case 5.');
                break;
            case 6:
                Log::info(' -- case 6.');
            default :
                Log::info(' -- case default.');
                $response = $menu->confirmation_message;

//                $notify = new NotifyController();
                //$notify->sendSms($user->phone_no,$response);
                //self::resetUser($user);
                self::sendResponse($response, 2, $user);

                break;
        }

    }

    //continuation
    public function continueSingleProcess($user, $message, $menu)
    {
        Log::info('Continue single process.');
        //validate input to be numeric
        $menuItem = UssdMenuItem::whereMenuIdAndStep($menu->id, $user->progress)->first();
        $message = str_replace(",", "", $message);

        Log::info('Switching menu id.');
        switch ($menu->id) {
            default :
                Log::info(' -- case default.');
                self::storeUssdResponse($user, $message);
                //check if we have another step
                $step = $user->progress + 1;
                $menuItem = UssdMenuItem::whereMenuIdAndStep($menu->id, $step)->first();
                if ($menuItem) {

                    $user->menu_item_id = $menuItem->id;
                    $user->menu_id = $menu->id;
                    $user->progress = $step;
                    $user->save();
                    return $menuItem->description;
                } else {
                    $response = self::confirmBatch($user, $menu);
                    return $response;

                }
                break;
        }

        return $response;
    }

    //continue USSD Menu
    public function continueUssdMenu($user, $message, $menu)
    {
        Log::info('Continue ussd menu.');
        //verify response
        $menu_items = self::getMenuItems($user->menu_id);

        $i = 1;
        $choice = "";
        $next_menu_id = 0;
        foreach ($menu_items as $key => $value) {
            if (self::validationVariations(trim($message), $i, $value->description)) {
                $choice = $value->id;
                $next_menu_id = $value->next_menu_id;

                break;
            }
            $i++;
        }
        if (empty($choice)) {
            Log::info('empty choice.');
            //get error, we could not understand your response
            $response = "We could not understand your response" . PHP_EOL;


            $i = 1;
            $response = $menu->title . PHP_EOL;
            foreach ($menu_items as $key => $value) {
                $response = $response . $i . ": " . $value->description . PHP_EOL;
                $i++;
            }

            return $response;
            //save the response
        } else {
            Log::info('Non empty choice.');
            //there is a selected choice
            $menu = UssdMenu::find($next_menu_id);
            //next menu switch
            $response = self::nextMenuSwitch($user, $menu);
            return $response;
        }

    }

    public function nextMenuSwitch($user, $menu)
    {
        Log::info('Next menu switcher.');

        Log::info('Switching menu type.');
//		print_r($menu);
//		exit;
        switch ($menu->type) {
            case 0:
                Log::info(' -- case 0.');
                //authentication mini app

                break;
            case 1:
                Log::info(' -- case 1.');
                //continue to another menu
                $menu_items = self::getMenuItems($menu->id);
                $i = 1;
                $response = $menu->title . PHP_EOL;
                foreach ($menu_items as $key => $value) {
                    $response = $response . $i . ": " . $value->description . PHP_EOL;
                    $i++;
                }

                $user->menu_id = $menu->id;
                $user->menu_item_id = 0;
                $user->progress = 0;
                $user->save();
                //self::continueUssdMenu($user,$message,$menu);
                break;
            case 2:
                Log::info(' -- case 2.');
                //start a process
//				print_r($menu);
//				exit;
                self::storeUssdResponse($user, $menu);

                $response = self::singleProcess($menu, $user, 1);
                return $response;

                break;
            case 3:
                Log::info(' -- case 3.');
                self::airtimeMiniApp($user, $menu);
//                self::infoMiniApp($user, $menu);
                break;
            default :
                Log::info(' -- case default.');
                self::resetUser($user);
                $response = "An authentication error occurred";
                break;
        }

        return $response;

    }

    public function validationVariations($message, $option, $value)
    {
        Log::info('Validation variations');
        if ((trim(strtolower($message)) == trim(strtolower($value))) || ($message == $option) || ($message == "." . $option) || ($message == $option . ".") || ($message == "," . $option) || ($message == $option . ",")) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    //store USSD response
    public function storeUssdResponse($user, $message)
    {
        Log::info('Store Ussd response: ' . $user . $message);

        $data = ['user_id' => $user->id, 'menu_id' => $user->menu_id, 'menu_item_id' => $user->menu_item_id, 'response' => $message];
        return UssdResponse::create($data);


    }

    //single process

    public function singleProcess($menu, $user, $step)
    {
        Log::info('Single Process.');
        Log::info([$menu, $step]);

        $menuItem = UssdMenuItem::whereMenuIdAndStep($menu->id, $step)->first();

        if ($menuItem) {
            //update user data and next request and send back
            $user->menu_item_id = $menuItem->id;
            $user->menu_id = $menu->id;
            $user->progress = $step;
            $user->session = 1;
            $user->save();
            return $menuItem->description;

        }

    }

    public function sendResponse($response, $type = 1, $user = null)
    {
        Log::info('Send response.');
        Log::info([$response, $type]);

        if ($type == 1) {
            $output = "CON ";
        } elseif ($type == 2) {
            $output = "CON ";
            $response = $response . PHP_EOL . "1. Back to main menu" . PHP_EOL . "2. Log out";
            $user->session = 4;
            $user->progress = 0;
            $user->save();
        } else {
            $output = "END ";
        }

        $output .= $response;
        header('Content-type: text/plain');
        echo $output;

        Log::info([$output]);

        exit;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string
     */
    public function getMenuAndItems($user, $menu_id)
    {
        Log::info('Get menu and items.');
        //get main menu

        $user->menu_id = $menu_id;
        $user->session = 1;
        $user->progress = 1;
        $user->save();
        //get home menu
        $menu = UssdMenu::find($menu_id);

        $menu_items = self::getMenuItems($menu_id);


        $i = 1;
        $response = $menu->title . PHP_EOL;
        foreach ($menu_items as $key => $value) {
            $response = $response . $i . ": " . $value->description . PHP_EOL;
            $i++;
        }

        return $response;
    }

    //Menu Items Function
    public static function getMenuItems($menu_id)
    {
        Log::info('Get menu items.');

        $menu_items = UssdMenuItem::whereMenuId($menu_id)->get();
        return $menu_items;
    }

    public function resetUser($user)
    {
        Log::info('Reset User.');

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
        Log::info('User is starting?');

        if (strlen($text) > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}