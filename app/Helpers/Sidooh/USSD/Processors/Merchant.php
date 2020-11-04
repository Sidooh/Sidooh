<?php


namespace App\Helpers\Sidooh\USSD\Processors;


use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Model\SubscriptionType;
use App\Models\UssdUser;

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
        switch ($previousScreen->key) {
            case "pay":
                $this->set_init();
                break;
            case "subscription":
                $this->set_amount($previousScreen);
                break;
            case "payment_method":
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
//        $this->get_class_name(get_parent_class()) . '|' .
        $this->vars['{$product}'] = $this->get_class_name();
        $this->vars['{$subscription_type_1}'] = "Sidooh Ambitious Agent";
        $this->vars['{$subscription_amount_1}'] = 475;

        $this->vars['{$subscription_type_2}'] = "Sidooh Thriving Agent";
        $this->vars['{$subscription_amount_2}'] = 975;

        $this->vars['{$period}'] = "month";

        $this->vars['{$number}'] = $this->phone;
        $this->vars['{$mpesa_number}'] = $this->phone;
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
        error_log("Subscription: finalize");

        $type = SubscriptionType::whereAmount($this->vars['{$amount}'])->firstOrFail();

        $phoneNumber = substr($this->vars['{$my_number}'], 1);
        $phone = $this->vars['{$number}'];

        (new \App\Models\Helpers\Sidooh\Subscription($type, $phoneNumber))->purchase($phone);
    }
}
