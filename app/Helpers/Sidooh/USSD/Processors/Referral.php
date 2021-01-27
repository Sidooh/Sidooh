<?php

namespace App\Helpers\Sidooh\USSD\Processors;


use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\UssdUser;
use App\Repositories\AccountRepository;
use App\Repositories\ReferralRepository;

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
            case "refer_fail":
            case "refer":
                $this->set_other_number($previousScreen);
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
                if ($this->screen->key == 'refer') {
                    $this->screen->title = 'Please set a pin under account > profile in order to proceed';
                }
            }
        } else {
            $this->screen->title = "Sorry, but you have not transacted on Sidooh previously. Please do so in order to refer friends.";
            $this->screen->type = 'OPEN';
        }
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
                $this->vars['{$number}'] = $phone;
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

    protected function finalize()
    {
//        TODO: Finalize transaction
        error_log("Referral: finalize");

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

        $message = "Hi, {$user} has referred you to Sidooh,
        a digital platform that gives you cash refunds on every airtime you purchase from the platform,
        out of which 80% is then automatically saved and invested to generate extra income for you.
        Dial $code NOW for FREE to buy airtime & start earning from your purchases.";

        (new AfricasTalkingApi())->sms($phone, $message);
    }
}
