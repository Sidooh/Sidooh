<?php


namespace App\Models\Helpers\Sidooh\USSD\Processors;


use App\Models\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Models\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\Model\SubscriptionType;
use App\Models\Models\UssdUser;

class Voucher extends Pay
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
        switch ($previousScreen->key) {
            case "pay":
                $this->set_init();
                break;
            case "other_number":
                $this->set_other_number($previousScreen);
                break;
            case "voucher_amount":
                $this->set_amount($previousScreen);
                break;
            case "payment_method":
                $this->set_payment_method($previousScreen);
                break;
//            case "payment_confirmation":
//                $this->set_payment_confirmation($previousScreen, $screen);
//                break;
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
    }

    private function set_other_number(Screen $previousScreen)
    {
        $this->vars['{$other_number}'] = $previousScreen->option_string;
        $this->vars['{$number}'] = $previousScreen->option_string;
    }

    private function set_amount(Screen $previousScreen)
    {
//        $this->vars['{$selected}'] = $this->vars['{$subscription_type_' . $previousScreen->option->value . '}'];
        $this->vars['{$amount}'] = $this->vars['{$subscription_amount_' . $previousScreen->option->value . '}'];
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
        error_log("Voucher: finalize");

        $phoneNumber = substr($this->vars['{$my_number}'], 1);
        $phone = $this->vars['{$number}'];
        $amount = $this->vars['{$amount}'];

        (new \App\Models\Helpers\Sidooh\Voucher($phone, $amount))->purchase();
    }
}
