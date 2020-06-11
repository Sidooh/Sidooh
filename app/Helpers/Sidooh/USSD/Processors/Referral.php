<?php

namespace App\Helpers\Sidooh\USSD\Processors;


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
    }

    private function set_other_number(Screen $previousScreen)
    {
        error_log("set_other_number");
        $number = $previousScreen->option_string;

        $phone = $this->validate_number($number);

        if ($phone != false && $phone != $this->validate_number($this->phone)) {
            $refRep = new ReferralRepository();
            $refRep->removeExpiredReferrals();
            $ref = $refRep->findByPhone($phone, true);

            $acc = (new AccountRepository())->findByPhone($phone);
//
            if (!$acc && !$ref) {
                $this->vars['{$number}'] = $phone;
            } else {
                $this->screen = $this->previousScreen;
                $this->screen->title = "Sorry the number you entered is not eligible for referral";
            }
        }
    }

    protected function finalize()
    {
//        TODO: Finalize transaction
        error_log("Referral: finalize");

        $phone = $this->vars['{$number}'];
        $phoneNumber = $this->vars['{$my_number}'];

        error_log($this->vars['{$number}']);

        $acc = (new AccountRepository())->create(['phone' => $phoneNumber]);
        $ref = (new ReferralRepository())->store([
            'account_id' => $acc->id,
            'phone' => $phoneNumber,
            'referee_phone' => $phone
        ]);

        error_log($ref->id);
    }
}
