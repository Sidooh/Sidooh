<?php


namespace App\Helpers\Sidooh\USSD\Processors;

use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\UssdUser;
use App\Repositories\AccountRepository;
use Propaganistas\LaravelPhone\PhoneNumber;

class Airtime extends Product
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

//    TODO: Can we move this to the parent class? as well as all the set methods below?
    protected function process_previous(Screen $previousScreen, Screen $screen)
    {
        switch ($previousScreen->key) {
            case "main_menu":
                $this->set_user_number();
                break;
            case "other_number":
                $this->set_other_number($previousScreen);
                break;
            case "airtime_amount":
                $this->set_amount($previousScreen);
                break;
            case "airtime_amount_v2":
                $this->set_amount($previousScreen, $version = 2);
                break;
            case "payment_method":
                $this->set_payment_method($previousScreen);
                break;
            case "payment_pin_confirmation":
                $this->check_current_pin($previousScreen);
                break;
            case "payment_confirmation":
                $this->set_payment_confirmation($previousScreen, $screen);
                break;
            case "other_number_mpesa":
                $this->set_payment_number($previousScreen);
                break;
        }
    }

    private function set_user_number()
    {
        $this->vars['{$product}'] = $this->get_class_name();
        $this->vars['{$my_number}'] = $this->phone;
        $this->vars['{$number}'] = $this->phone;
        $this->vars['{$mpesa_number}'] = $this->phone;
    }

    private function set_other_number(Screen $previousScreen)
    {
        $this->vars['{$other_number}'] = $previousScreen->option_string;
        $this->vars['{$number}'] = $previousScreen->option_string;
    }

    private function set_amount(Screen $previousScreen, $version = 1)
    {
        if ($version == 2)
            $this->vars['{$amount}'] = $previousScreen->option_string;
        else
            $this->vars['{$amount}'] = $previousScreen->option->value;

//        TODO: How can this computation be made dynamic to include ATs variable discount?
        $this->vars['{$product}'] = $this->vars['{$product}'] . ' (which will earn you ' . $this->vars['{$amount}'] / 200 . ' points)';
    }

    private function check_current_pin(Screen $previousScreen)
    {
        $acc = (new AccountRepository)->findByPhone($this->phone);

        if ($acc)
            if ($acc->pin) {
//                if (!Hash::check($previousScreen->option_string, $res->pin)) {
                if ($previousScreen->option_string !== $acc->pin) {
                    $this->screen->title = "Sorry, but the pin does not match. Please call us if you have forgotten your PIN";
                    $this->screen->type = 'END';
                } else {
                    return $acc;
                }
            } else {
                $this->screen->title = "Sorry, but you have not set a pin. Please do so in order to be able to proceed.";
                $this->screen->type = 'END';
            }
        else {
            $this->screen->title = "Sorry, but you have not transacted on Sidooh previously. Please do so in order to access your account.";
            $this->screen->type = 'END';
        }

        return null;
    }

    private function set_payment_method(Screen $previousScreen)
    {
        $method = $this->methods($previousScreen->option->value);
        $this->vars['{$payment_method}'] = $method;
        $method_text = $method;

        if ($method === PaymentMethods::MPESA) {
            $this->vars['{$method_instruction}'] = 'PLEASE ENTER MPESA PIN when prompted';
            $method_text .= ' ' . $this->vars['{$mpesa_number}'];
        }

        if ($method === PaymentMethods::VOUCHER) {

            $acc = (new AccountRepository)->findByPhone($this->phone);

            if ($acc)
                if ($acc->voucher) {
                    $bal = $acc->voucher->balance;

                    if ($bal == 0 || $bal < (int)$this->vars['{$amount}']) {
//                        TODO: Can we create a completely new screen and populate it?
                        $this->screen->title = "Sorry, your voucher balance is insufficient. Please top-up your Sidooh Voucher to continue enjoying the service.";
                        $this->screen->type = 'END';
                    }

                } else {
                    $this->screen->title = "Sorry, but you have not purchased a voucher before. Please do so in order to be able to proceed.";
                    $this->screen->type = 'END';
                }

            else {
                $this->screen->title = "Sorry, but you have not transacted on Sidooh previously. Please do so in order to proceed.";
                $this->screen->type = 'END';
            }

            $method_text .= ' (KSh' . number_format($bal) . ')';
            $this->vars['{$method_instruction}'] = "Your $method_text will be debited automatically";
            array_pop($this->screen->options);
        }

        $this->vars['{$payment_method_text}'] = $method_text;
    }

    private function set_payment_confirmation(Screen $previousScreen, Screen $screen)
    {
//        TODO: Check if MPESA method selected set number to be user number
    }

    private function set_payment_number(Screen $previousScreen)
    {
        $this->vars['{$mpesa_number}'] = ltrim(PhoneNumber::make($previousScreen->option_string, 'KE')->formatE164(), '+');
        $this->vars['{$payment_method_text}'] = $this->vars['{$payment_method}'] . ' ' . $this->vars['{$mpesa_number}'];
    }

    protected function finalize()
    {
//        TODO: Finalize transaction
//        TODO: Check pin and voucher first
        error_log("Airtime: finalize");

        $amount = $this->vars['{$amount}'];
        $phoneNumber = $this->vars['{$my_number}'];
        $target = $this->vars['{$other_number}'];
        $mpesa = $this->vars['{$mpesa_number}'];
        $method = $this->vars['{$payment_method}'];

        if (!isset($amount) || !isset($phoneNumber))
            $this->screen->next = "error";
        else
            (new \App\Helpers\Sidooh\Airtime($amount, $phoneNumber, $method))->purchase($target, $mpesa);
    }
}
