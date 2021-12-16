<?php


namespace App\Helpers\Sidooh\USSD\Processors;


use App\Helpers\Sidooh\USSD\Entities\Option;
use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Repositories\AccountRepository;
use Nabcellent\Kyanda\Library\Providers;

class Utility extends Pay
{
    protected function process_previous(Screen $previousScreen, Screen $screen)
    {
//        error_log("---------------- Utility process previous");
//        error_log($this->previousScreen->key);
//        error_log($screen->key);
//        error_log("---------------- ");
        switch ($this->previousScreen->key) {
            case "pay":
                $this->set_init();
                break;
            case "utility":
                $this->set_utility();
                break;
            case "utility_account_select":
                $this->set_selected_account_number();
                break;
            case "utility_account_no":
                $this->set_account_number();
                break;
            case "utility_amount":
                $this->set_amount();
                break;
            case "payment_method":
                $this->set_payment_method();
                break;
            case "other_number_mpesa":
                $this->set_payment_number();
                break;
        }
    }

//    TODO: Can we move this to the parent class? as well as all the set methods below?
    private function set_init()
    {
        $this->vars['{$product}'] = $this->get_class_name();
        $this->vars['{$number}'] = $this->phone;
        $this->vars['{$mpesa_number}'] = $this->phone;

        if (!config('services.sidooh.utilities_enabled')) {
            $this->screen->key = "coming_soon";
            $this->screen->title = "Coming Soon.";
            $this->screen->options = [];
//            $this->screen->type = "OPEN";
        }
    }

    private function set_utility()
    {
        $this->vars['{$option}'] = $this->previousScreen->option->value;

        $this->vars['{$product}'] = 'to ' . $this->previousScreen->option->title;

        $option = null;

        switch ($this->vars['{$option}']) {
            case 1:
                $option = Providers::KPLC_PREPAID;
                break;
            case 2:
                $option = Providers::KPLC_POSTPAID;
                break;
            case 3:
                $option = Providers::NAIROBI_WTR;
                break;
            case 4:
                $option = Providers::DSTV;
                break;
            case 5:
                $option = Providers::ZUKU;
                break;
            case 6:
                $option = Providers::GOTV;
                break;
            case 7:
                $option = Providers::STARTIMES;
                break;
        }

        $account = (new AccountRepository())->accountWithUtilityAccountsByProvider($this->phone, $option);

        if ($account->utility_accounts && $account->utility_accounts->isNotEmpty()) {
            $varUtilityAccountOpts = array();
            $utilityAccountOptions = array();
            $counter = 1;

            foreach ($account->utility_accounts as $uA) {
                $option = (new Option())->create($uA->utility_number, 'int', $counter, 'utility_amount');
                array_push($utilityAccountOptions, $option);

                $varUtilityAccountOpts[$counter] = $uA->utility_number;
                $counter += 1;
            }

            array_push($utilityAccountOptions, ...$this->screen->options);
            $this->screen->options = $utilityAccountOptions;

            $this->addVars('{$utility_account_options}', json_encode($varUtilityAccountOpts));

        } else {
            $this->screen->title .= "\n\n No accounts saved, please add account below.\n";
            $this->screen->options[0]->title = "Enter account no.";
        }
    }

    private function set_selected_account_number()
    {
        $selectedUtilityAccount = $this->previousScreen->option->value;
        $utilityAccountOptions = json_decode($this->vars['{$utility_account_options}'], true);

        if ($utilityAccountOptions && in_array($selectedUtilityAccount, array_keys($utilityAccountOptions))) {

            $this->vars['{$account_number}'] = $utilityAccountOptions[$selectedUtilityAccount];

            $this->vars['{$my_number}'] = $this->phone;
            $this->vars['{$number}'] = $this->vars['{$account_number}'];
        }
    }

    private function set_account_number()
    {
        $this->vars['{$account_number}'] = $this->previousScreen->option_string;

        $this->vars['{$my_number}'] = $this->phone;
        $this->vars['{$number}'] = $this->vars['{$account_number}'];
    }

    private function set_amount()
    {
        $this->vars['{$amount}'] = $this->previousScreen->option_string;
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

    private function set_payment_number()
    {
        $this->vars['{$mpesa_number}'] = $this->previousScreen->option_string;
        $this->vars['{$payment_method_text}'] = $this->vars['{$payment_method}'] . ' ' . $this->vars['{$mpesa_number}'];
    }

    protected function finalize()
    {
//        TODO: Finalize transaction
        error_log("Utility: finalize");

        $phone = $this->vars['{$my_number}'];
        $option = (int)$this->vars['{$option}'];
        $amount = (int)$this->vars['{$amount}'];
        $accountNumber = (int)$this->vars['{$account_number}'];
        $mpesa = $this->vars['{$mpesa_number}'];
        $method = $this->vars['{$payment_method}'];

        (new \App\Helpers\Sidooh\Utility($phone, $option, $amount, $accountNumber, $method))->purchase($mpesa);
    }
}
