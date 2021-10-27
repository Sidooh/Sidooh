<?php


namespace App\Helpers\Sidooh\USSD\Processors;


use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\UssdUser;
use App\Repositories\AccountRepository;

class Utility extends Pay
{
    protected function process_previous(Screen $previousScreen, Screen $screen)
    {
        error_log("---------------- Utility process previous");
        error_log($this->previousScreen->key);
        error_log($screen->key);
        error_log("---------------- ");
        switch ($this->previousScreen->key) {
            case "pay":
                $this->set_init();
                break;
            case "utility":
                $this->set_utility();
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
    }

    private function set_utility()
    {
        $this->vars['{$option}'] = $this->previousScreen->option->value;

        $this->vars['{$product}'] = 'to ' . $this->previousScreen->option->title;
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
