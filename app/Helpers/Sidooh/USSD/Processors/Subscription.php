<?php


namespace App\Helpers\Sidooh\USSD\Processors;


use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\SubscriptionType;
use App\Models\UssdUser;
use App\Repositories\AccountRepository;

class Subscription extends Pay
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
            case "payment_pin_confirmation":
                $this->check_current_pin($previousScreen);
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
        $this->vars['{$subscription_type_1}'] = "Sidooh Aspiring Agent";
        $this->vars['{$subscription_amount_1}'] = 475;

        $this->vars['{$subscription_type_2}'] = "Sidooh Thriving Agent";
        $this->vars['{$subscription_amount_2}'] = 975;

        $this->vars['{$period}'] = "month";

        $this->vars['{$number}'] = $this->phone;
        $this->vars['{$mpesa_number}'] = $this->phone;
    }

    private function set_amount(Screen $previousScreen)
    {
        $this->vars['{$amount}'] = $this->vars['{$subscription_amount_' . $previousScreen->option->value . '}'];
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
                        $this->screen->title = "Sorry but your Voucher Balance is insufficient";
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

    private function set_payment_number(Screen $previousScreen)
    {
        $this->vars['{$mpesa_number}'] = $previousScreen->option_string;
    }

    protected function finalize()
    {
//        TODO: Finalize transaction
//        TODO: For all Pin flows, use bool 'confirm pin' to check if pin confirmed
        error_log("Subscription: finalize");

        $type = SubscriptionType::whereAmount($this->vars['{$amount}'])->firstOrFail();

        $phoneNumber = ltrim($this->vars['{$my_number}'], '+');
        $phone = $this->vars['{$number}'];
        $method = $this->vars['{$payment_method}'];

        (new \App\Helpers\Sidooh\Subscription($type, $phoneNumber, $method))->purchase($phone);
    }
}
