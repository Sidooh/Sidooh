<?php


namespace App\Helpers\Sidooh\USSD\Processors;


use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\UssdUser;
use App\Repositories\AccountRepository;
use App\Repositories\MerchantRepository;

class Merchant extends Pay
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
//        error_log("---------------- Merchant process previous");
//        error_log($previousScreen->key);
//        error_log($screen->key);
//        error_log("---------------- ");
        switch ($previousScreen->key) {
            case "pay":
                $this->set_init();
                break;
            case "merchant":
                $this->set_merchant_code($previousScreen);
                break;
            case "merchant_payment":
                $this->set_amount($previousScreen);
                break;
            case "merchant_payment_method":
                $this->set_payment_method($previousScreen);
                break;
            case "other_number_mpesa":
                $this->set_payment_number($previousScreen);
                break;
        }
    }

//    TODO: Can we move this to the parent class? as well as all the set methods below?
    private function set_init()
    {
        $this->vars['{$product}'] = $this->get_class_name();
        $this->vars['{$number}'] = $this->phone;
        $this->vars['{$mpesa_number}'] = $this->phone;
        $this->vars['{$payment_method}'] = PaymentMethods::VOUCHER;
    }


    private function set_merchant_code(Screen $previousScreen)
    {
        $merchant = (new MerchantRepository)->findByCode($previousScreen->option_string);

        if ($merchant) {

            $this->vars['{$merchant_code}'] = $merchant->code;
            $this->vars['{$merchant_name}'] = $merchant->name;

            if ($merchant->userPoints) {
                $this->vars['{$merchant_points}'] = $merchant->userPoints;
                $this->vars['{$merchant_points_value}'] = $merchant->userPointsValue;
            } else {
                $this->screen->next = 'merchant_payment_confirmation';
            }

        } else {
            $this->screen->title = "Sorry, but this merchant does not exist. Please try again.";
            $this->screen->type = 'END';
        }
//
//        error_log("---------------- Merchant set_merchant_code");
//        error_log(json_encode($this->screen));
//        error_log("----------------");

    }

    private function set_amount(Screen $previousScreen)
    {
        $this->vars['{$amount}'] = $previousScreen->option_string;

        $acc = (new AccountRepository)->findByPhone($this->phone);

        if ($acc)
            if ($acc->voucher) {
                $bal = $acc->voucher->balance;

                if ($bal == 0 || $bal < (int)$this->vars['{$amount}']) {
                    $this->screen->title = "Sorry but your Voucher Balance is insufficient";
                    $this->screen->type = 'END';
                }

                $method_text = $this->vars['{$payment_method}'];
                $method_text .= ' (KSh' . number_format($bal) . ')';
                $this->vars['{$method_instruction}'] = "Your $method_text will be debited automatically";
                $this->vars['{$payment_method_text}'] = $method_text;

            } else {
                $this->screen->title = "Sorry, but you have not purchased a voucher before. Please do so in order to be able to proceed.";
                $this->screen->type = 'END';
            }

        else {
            $this->screen->title = "Sorry, but you have not transacted on Sidooh previously. Please do so in order to proceed.";
            $this->screen->type = 'END';
        }
//
//        error_log("---------------- Merchant set_amount");
//        error_log(json_encode($this->screen));
//        error_log("----------------");

    }

    private function set_payment_method(Screen $previousScreen)
    {
        $method = $this->methods($previousScreen->option->value);
        $this->vars['{$payment_method}'] = $method;

        if ($method === PaymentMethods::MPESA) {
            $this->vars['{$method_instruction}'] = 'PLEASE ENTER MPESA PIN when prompted';
        }
    }

    private function set_payment_number(Screen $previousScreen)
    {
        $this->vars['{$mpesa_number}'] = $previousScreen->option_string;
    }

    protected function finalize()
    {
//        TODO: Finalize transaction
        error_log("Merchant: finalize");

        $phoneNumber = substr($this->vars['{$my_number}'], 1);
        $merchant = (new MerchantRepository)->findByCode($this->vars['{$merchant_code}']);
        $amount = $this->vars['{$amount}'];

        if ($merchant && $this->screen->key !== 'merchant_payment_confirmation')
            (new \App\Helpers\Sidooh\Merchant($merchant, $phoneNumber))->purchase($amount);

    }

}
