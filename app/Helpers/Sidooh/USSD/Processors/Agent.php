<?php


namespace App\Helpers\Sidooh\USSD\Processors;

use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Model\SubscriptionType;
use App\Model\User;
use App\Models\UssdUser;
use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Hash;

class Agent extends Product
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

    private function set_payment_confirmation(Screen $previousScreen, Screen $screen)
    {
//        TODO: Check if MPESA method selected set number to be user number
    }

    private function set_payment_number(Screen $previousScreen)
    {
        $this->vars['{$mpesa_number}'] = $previousScreen->option_string;
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

        (new \App\Helpers\Sidooh\Subscription($type, $phoneNumber))->purchase($phone);
    }
}
