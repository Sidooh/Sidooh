<?php


namespace App\Helpers\Sidooh\USSD\Processors;

use App\Helpers\Sidooh\USSD\Entities\Option;
use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Repositories\AccountRepository;
use Propaganistas\LaravelPhone\PhoneNumber;

class Airtime extends Product
{

//    TODO: Can we move this to the parent class? as well as all the set methods below?
    protected function process_previous(Screen $previousScreen, Screen $screen)
    {
        switch ($previousScreen->key) {
            case "main_menu":
                $this->set_user_number();
                break;
            case "airtime":
                $this->set_airtime();
                break;
            case "other_number_select":
                $this->set_selected_airtime_number();
                break;
            case "other_number":
                $this->set_other_number();
                break;
            case "airtime_amount":
                $this->set_amount();
                break;
            case "airtime_amount_v2":
                $this->set_amount(2);
                break;
            case "payment_method":
                $this->set_payment_method();
                break;
            case "payment_pin_confirmation":
                $this->check_current_pin();
                break;
            case "payment_confirmation":
                $this->set_payment_confirmation();
                break;
            case "other_number_mpesa":
                $this->set_payment_number();
                break;
        }
    }

    private function set_user_number()
    {
        $this->vars['{$class}'] = $this->get_class_name();
        $this->vars['{$product}'] = $this->get_class_name();
        $this->vars['{$my_number}'] = $this->phone;
        $this->vars['{$number}'] = $this->phone;
        $this->vars['{$mpesa_number}'] = $this->phone;
    }

    private function set_airtime()
    {
        $selected = $this->previousScreen->option->value;

        if ($selected != "2") {
            return;
        }

        $account = (new AccountRepository())->accountWithAirtimeAccounts($this->phone);

        if ($account->airtime_accounts && $account->airtime_accounts->isNotEmpty()) {
            $varAirtimeAccountOpts = array();
            $airtimeAccountOptions = array();
            $counter = 1;

            foreach ($account->airtime_accounts as $uA) {
                $option = (new Option())->create($uA->airtime_number, 'int', $counter, 'airtime_amount_v2');
                array_push($airtimeAccountOptions, $option);

                $varAirtimeAccountOpts[$counter] = $uA->airtime_number;
                $counter += 1;
            }

            array_push($airtimeAccountOptions, ...$this->screen->options);
            $this->screen->options = $airtimeAccountOptions;

            $this->addVars('{$airtime_account_options}', json_encode($varAirtimeAccountOpts));

        } else {
            $this->screen->title .= "\n\n No numbers saved. Select option below to add number.\n";
//            $this->screen->options[0]->title = "Enter other no.";
        }

    }

    private function set_selected_airtime_number()
    {
        $selectedAirtimeAccount = $this->previousScreen->option->value;
        $airtimeAccountOptions = json_decode($this->vars['{$airtime_account_options}'], true);

        if ($airtimeAccountOptions && in_array($selectedAirtimeAccount, array_keys($airtimeAccountOptions))) {

            $this->vars['{$airtime_number}'] = $airtimeAccountOptions[$selectedAirtimeAccount];

            $this->vars['{$my_number}'] = $this->phone;
            $this->vars['{$other_number}'] = $this->vars['{$airtime_number}'];
            $this->vars['{$number}'] = $this->vars['{$airtime_number}'];
        }
    }

    private function set_other_number()
    {
        $this->vars['{$other_number}'] = $this->previousScreen->option_string;
        $this->vars['{$number}'] = $this->previousScreen->option_string;
    }

    private function set_amount($version = 1)
    {
        if ($version == 2)
            $this->vars['{$amount}'] = $this->previousScreen->option_string;
        else
            $this->vars['{$amount}'] = $this->previousScreen->option->value;

//        TODO: How can this computation be made dynamic to include ATs variable discount?
//        TODO: Change to $product_text in case of going back it doesn't concatenate forever.
        $this->vars['{$product}'] = $this->vars['{$class}'] . ' (which will earn you ' . $this->getPointsEarned($this->vars['{$amount}']) . ' points)';
    }


//    TODO: Refactor this to external file?
    public function getPointsEarned(float $amount)
    {
        return $amount * .06 * .1;
    }

    private function check_current_pin()
    {
        $acc = (new AccountRepository)->findByPhone($this->phone);

        if ($acc)
            if ($acc->pin) {
//                if (!Hash::check($this->previousScreen->option_string, $res->pin)) {
                if ($this->previousScreen->option_string !== $acc->pin) {
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

    private function set_payment_method()
    {
        $method = $this->methods($this->previousScreen->option->value);
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

    private function set_payment_confirmation()
    {
//        TODO: Check if MPESA method selected set number to be user number
    }

    private function set_payment_number()
    {
        $this->vars['{$mpesa_number}'] = ltrim(PhoneNumber::make($this->previousScreen->option_string, 'KE')->formatE164(), '+');
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
