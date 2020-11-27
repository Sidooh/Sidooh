<?php


namespace App\Helpers\Sidooh\USSD\Processors;

use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\SubscriptionType;
use App\Models\User;
use App\Models\UssdUser;
use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Hash;

class Agent extends AgentMain
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
            case "agent":
                $this->set_user_number();
                break;
            case "agent_onboarding_name":
                $this->set_name($previousScreen);
                break;
            case "agent_onboarding_mail":
                $this->set_email($previousScreen);
                break;
            case "agent_onboarding_category":
                $this->set_amount($previousScreen);
                break;
            case "payment_method":
                $this->set_payment_method($previousScreen);
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

        $this->vars['{$subscription_type_1}'] = "Sidooh Ambitious Agent";
        $this->vars['{$subscription_amount_1}'] = 475;
        $this->vars['{$level_limit_1}'] = 3;
        $this->vars['{$subscription_type_2}'] = "Sidooh Thriving Agent";
        $this->vars['{$subscription_amount_2}'] = 975;
        $this->vars['{$level_limit_2}'] = 5;
        $this->vars['{$period}'] = "month";

        $this->vars['{$email}'] = $this->vars['{$my_number}'] . "@sid.ooh";

    }

    private function set_name(Screen $previousScreen)
    {
        $this->vars['{$name}'] = $previousScreen->option_string;
    }

    private function set_email(Screen $previousScreen)
    {
        if ($previousScreen->option_string == "0000")
            $this->vars['{$email}'] = $this->vars['{$my_number}'] . "@sid.ooh";
        else
            $this->vars['{$email}'] = $previousScreen->option_string;
    }

    private function set_amount(Screen $previousScreen)
    {
        $this->vars['{$subscription_type}'] = $this->vars['{$subscription_type_' . $previousScreen->option->value . '}'];
        $this->vars['{$amount}'] = $this->vars['{$subscription_amount_' . $previousScreen->option->value . '}'];
        $this->vars['{$product}'] = $this->vars['{$subscription_type}'];
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

    private function set_payment_confirmation(Screen $previousScreen, Screen $screen)
    {
//        TODO: Check if MPESA method selected set number to be user number
    }

    private function set_payment_number(Screen $previousScreen)
    {
        $this->vars['{$mpesa_number}'] = $previousScreen->option_string;
        $this->vars['{$payment_method_text}'] = $this->vars['{$payment_method}'] . ' ' . $this->vars['{$mpesa_number}'];
    }

    protected function finalize()
    {
//        TODO: Finalize transaction
        error_log("Agent: finalize");

        $type = SubscriptionType::whereAmount($this->vars['{$amount}'])->firstOrFail();

        $phoneNumber = $this->vars['{$my_number}'];
        $phone = $this->vars['{$number}'];

        $name = $this->vars['{$name}'];
        $email = $this->vars['{$email}'];
        $pass = $this->vars['{$email}'] . '5!D00h';
        $method = $this->vars['{$payment_method}'];

        $acc = (new AccountRepository())->create(['phone' => $phoneNumber]);

        $user = $acc->user;

//        TODO: Fix this!!!
        if (!$user)
            $user = User::firstOrCreate(
                [
                    'username' => $phone,
                ],
                [
                    'name' => $name,
                    'username' => $phone,
                    'id_number' => $phone,
                    'email' => $email,
                    'password' => Hash::make($pass)
                ]);

        $acc->user()->associate($user);
        $acc->save();

        (new \App\Helpers\Sidooh\Subscription($type, $phoneNumber, $method))->purchase($phone);
    }
}
