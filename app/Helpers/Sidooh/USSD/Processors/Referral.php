<?php

namespace App\Helpers\Sidooh\USSD\Processors;


use App\Helpers\Sidooh\USSD\Entities\Option;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\User;
use App\Models\UssdUser;
use App\Repositories\AccountRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\ReferralRepository;
use Illuminate\Support\Facades\Hash;

class Referral extends Product
{
    /**
     * @param UssdUser $user
     * @param Screen $previousScreen
     * @param Screen $screen
     * @return Screen
     */
    public function process(UssdUser $user, Screen $previousScreen, Screen $screen)
    {
        return parent::process($user, $previousScreen, $screen);
    }

    protected function process_previous(Screen $previousScreen, Screen $screen)
    {
        error_log("PROCESS PREVIOUS");
        error_log($previousScreen->key);

        switch ($previousScreen->key) {
            case "main_menu":
                $this->set_init();
                break;
            case "refer_pin":
                $this->check_current_pin($previousScreen);
                break;
            case "refer_fail":
            case "refer":
                $this->set_other_number($previousScreen);
                break;
//            case "refer_end":
//                $this->refer();
//                break;
            case "kyc_details_name":
                $this->set_name($previousScreen);
                break;
            case "kyc_details_mail":
                $this->set_email($previousScreen);
                break;
            case "kyc_details_new_pin":
                $this->set_pin($previousScreen);
                break;
            case "kyc_details_new_pin_confirm":
                $this->set_pin_confirm($previousScreen);
                break;
        }
    }

//    TODO: Can we move this to the parent class? as well as all the set methods below?

    private function set_init()
    {
        $this->vars['{$product}'] = $this->get_class_name();
        $this->vars['{$enrollment_time}'] = 48;

        $res = (new AccountRepository)->findByPhone($this->phone);

        if ($res) {
            if (!$res->pin) {
                $this->vars['{$has_pin}'] = false;

                if ($this->screen->key == 'refer_pin') {

                    unset($this->screen->option_type, $this->screen->next);
                    $this->screen->type = null;

                    $option = new Option();
                    $option->title = "Set Pin";
                    $option->type = "int";
                    $option->value = "1";
                    $option->next = "kyc_details_name";

                    $this->screen->options = [
                        "1" => $option
                    ];
                    $this->screen->title = 'Please set a pin in order to proceed';
                }
            }
        } else {
            $this->screen->title = "Sorry, you have not yet purchased airtime on Sidooh. Please do so in order to access your account.";
            $this->screen->type = 'OPEN';
        }
    }

    private function check_current_pin(Screen $previousScreen)
    {
        $acc = (new AccountRepository)->findByPhone($this->phone);
//        $this->vars['{$pin_tries}'] -= 1;

        if ($acc)
            if ($acc->pin) {
//                if (!Hash::check($previousScreen->option_string, $res->pin)) {
                if ($previousScreen->option_string !== $acc->pin) {
//                    if ($this->vars['{$pin_tries}'] == 0) {
                    $this->screen->type = 'END';
                    $this->screen->title = "Sorry, but the pin does not match. Please call us if you have forgotten your PIN.";
//                    }

//                    $this->screen->title = "Sorry, but the pin does not match. You have " . $this->vars['{$pin_tries}'] . " more tries.";
//
                } else {
                    return $acc;
                }
            } else {
//                $this->screen->title = "Sorry, but you have not set a pin. Please do so in order to be able to proceed.";
//                $this->screen->type = 'END';
                $screen = new Screen();
                $screen->key = 'kyc_details_name';
                $screen->title = "Please enter your Full Name\n\nFormat:\nFirstname Lastname";
                $screen->type = "OPEN";
                $screen->next = "kyc_details_new_pin";
                $screen->option_type = "NAME";

                $this->screen = $screen;
            }
        else {
            $this->screen->title = "Sorry, you have not yet purchased airtime on Sidooh. Please do so in order to access your account.";
            $this->screen->type = 'END';
        }

        return null;
    }

    private function set_other_number(Screen $previousScreen)
    {
        error_log("set_other_number");
        $number = $previousScreen->option_string;

        $phone = ltrim($this->validate_number($number), '+');
        $my_phone = ltrim($this->validate_number($this->phone), '+');

        if ($phone != false && $phone != $my_phone) {
            $refRep = new ReferralRepository();
            $refRep->removeExpiredReferrals();
            $ref = $refRep->findByPhone($phone, true);

            $acc = (new AccountRepository())->findByPhone($phone);
//
            if (!$acc && !$ref) {

                if (!preg_match('(^(?:\+?254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$)', $phone)) {
                    $this->screen = $this->previousScreen;
                    $this->screen->title = "Sorry the number you entered is not eligible for referral. Only SAFARICOM is currently supported.";
                } else {
                    $this->vars['{$number}'] = $phone;
                    $this->refer();
                }

            } else {

//                error_log('----------------');
//                error_log("Invalid number");
//                error_log($this->screen->key);
//                error_log($this->previousScreen->key);
//                error_log('----------------');

                if ($this->screen->key == 'refer_end') {
                    $this->screen = $this->previousScreen;
                    $this->screen->title = "Sorry the number you entered is not eligible for referral.";
                }

                if ($acc) {
                    $this->screen->title .= "The number is already registered by an existing user.";
                } else if ($ref) {
                    $this->screen->title .= "The number has been referred within the last 48 hrs. Please try again later.";
                }
            }
        }
    }

    private function set_name(Screen $previousScreen)
    {
        $this->vars['{$name}'] = $previousScreen->option_string;
        $this->vars['{$email}'] = $this->vars['{$my_number}'] . "@sid.ooh";
    }

    private function set_email(Screen $previousScreen)
    {
        if ($previousScreen->option_string == "0000")
            $this->vars['{$email}'] = $this->vars['{$my_number}'] . "@sid.ooh";
        else
            $this->vars['{$email}'] = $previousScreen->option_string;
    }

    private function set_pin(Screen $previousScreen)
    {
        $this->vars['{$pin}'] = $previousScreen->option_string;
    }

    private function set_pin_confirm(Screen $previousScreen)
    {
        if ($previousScreen->option_string === $this->vars['{$pin}']) {
            $this->vars['{$confirm_pin}'] = $previousScreen->option_string;
        } else {
            $this->screen->title = "PINs don't match\n Please try again.";
        }
    }

    protected function finalize()
    {
//        TODO: Finalize transaction
        error_log("Referral: finalize");

        if ($this->screen->key == 'kyc_details_pin_end') {
            $this->setPinAndUser();
        }

        if ($this->screen->key == 'refer_end') {
            $this->refer();
        }

    }

    private function setPinAndUser()
    {
        $phone = $this->vars['{$my_number}'];
//
        $name = $this->vars['{$name}'];
        $email = $this->vars['{$email}'];
        $pass = $this->vars['{$email}'] . '5!D00h';
        $pin = $this->vars['{$confirm_pin}'];

        $acc = (new AccountRepository)->findByPhone($this->phone);

//        $acc->pin = Hash::make($pin);
        $acc->pin = $pin;

        $user = $acc->user;

        if (!$acc->user)
            $user = User::firstOrCreate(
                [
                    'username' => $phone,
                ],
                [
                    'name' => $name,
                    'username' => $phone,
                    'id_number' => $phone,
                    'email' => $email,
                    'password' => Hash::make($pass)
                ]);

        $acc->user()->associate($user);
        $acc->save();
    }

    private function refer()
    {
        $phone = $this->vars['{$number}'];
        $phoneNumber = $this->vars['{$my_number}'];

        $acc = (new AccountRepository())->create(['phone' => $phoneNumber]);
        $ref = (new ReferralRepository())->store([
            'account_id' => $acc->id,
            'phone' => $phoneNumber,
            'referee_phone' => $phone
        ]);
        $code = config('services.at.ussd.code');

        $user = $acc->phone;

        if ($acc->user)
            $user .= ' - ' . ucwords($acc->user->name);

        $message = "Hi, {$user} has invited you to try out Sidooh, ";
        $message .= "a digital platform that gives you cash refunds on every airtime you purchase from the platform, ";
        $message .= "out of which 80% is then automatically saved and invested to generate extra income for you. ";
        $message .= "Dial $code NOW for FREE on your Safaricom line to buy airtime & start earning from your purchases.";

        NotificationRepository::sendSMS([$phone], $message);
    }
}
