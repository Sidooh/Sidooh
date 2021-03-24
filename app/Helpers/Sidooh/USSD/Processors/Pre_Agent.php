<?php


namespace App\Helpers\Sidooh\USSD\Processors;

use App\Helpers\Sidooh\USSD\Entities\Option;
use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\SubscriptionType;
use App\Models\User;
use App\Models\UssdUser;
use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Hash;

class Pre_Agent extends AgentMain
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
            case "pre_agent_onboarding_name":
                $this->set_name($previousScreen);
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

        $this->vars['{$subscription_type}'] = "Sidooh Agent";
        $this->vars['{$subscription_amount}'] = 4350;
        $this->vars['{$subscription_amount_f}'] = '4,350';
        $this->vars['{$level_limit}'] = 5;
        $this->vars['{$period}'] = "1 YEAR";


        $res = (new AccountRepository)->findByPhone($this->phone);
//        Log::info($res);

        if ($res) {
            $name = "Customer";

            if ($res->user_id) {
                $user = $res->user;

                $name = $user->name;
            }

//            TODO: Add screen to handle existing subscription and option to upgrade
            if ($res->active_subscription) {
                $subscription = $res->active_subscription->subscription_type->title;
                $subdate = $res->active_subscription->created_at->addMonths($res->active_subscription->subscription_type->duration)->toFormattedDateString();

                $this->screen->title = "Dear {$name}, you are already subscribed to $subscription valid until $subdate.";

                if ($res->active_subscription->subscription_type->duration == 1) {
                    $option = $this->screen->options[0];
                    $option->next = "pre_agent_onboarding_category";

                    $this->vars['{$name}'] = $name;

                } else {
                    if ($res->active_subscription->subscription_type->level_limit == 3) {

                        $option = new Option();
                        $option->title = "Upgrade to " . $this->vars['{$subscription_type_2}'] . "@" . $this->vars['{$subscription_amount_2}'] . '/' . $this->vars['{$period}'];
                        $option->type = "int";
                        $option->value = "2";
                        $option->next = "payment_method";

//                        if ($res->active_subscription->subscription_type->level_limit == 3) {
                        $this->screen->options = [
                            "2" => $option,
                        ];
//                        } else {
//                            $option2 = new Option();
//                            $option2->title = "Upgrade to " . $this->vars['{$subscription_type_1}'] . "@" . $this->vars['{$subscription_amount_1}'] . '/' . $this->vars['{$period}'];
//                            $option2->type = "int";
//                            $option2->value = "1";
//                            $option2->next = "payment_method";
//
//                            $this->screen->options = [
//                                "1" => $option2,
//                                "2" => $option
//                            ];
//                        }

//                        $this->vars['{$subscription_upgrade}'] = $this->vars['{$subscription_type_2}'];
                        $this->vars['{$subscription_type}'] = $this->vars['{$subscription_type_2}'];
                        $this->vars['{$amount}'] = $this->vars['{$subscription_amount_2}'];
                        $this->vars['{$product}'] = $this->vars['{$subscription_type}'];
                    } else {
                        $this->screen->options = [];
                    }

                }

            }

        } else {
            $this->screen->title = "Sorry, you have not yet purchased airtime on Sidooh. Please do so in order to proceed.";
            $this->screen->type = 'OPEN';
            unset($this->screen->option_type, $this->screen->next, $this->screen->options);
        }
    }

    private function set_name(Screen $previousScreen)
    {
        $this->vars['{$name}'] = $previousScreen->option_string;
        $this->vars['{$email}'] = $this->vars['{$my_number}'] . "@sid.ooh";
        $this->vars['{$amount}'] = $this->vars['{$subscription_amount}'];
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
                        $this->screen->type = 'OPEN';
                    }

                } else {
                    $this->screen->title = "Sorry, but you have not purchased a voucher before. Please do so in order to be able to proceed.";
                    $this->screen->type = 'END';
                }

            else {
                $this->screen->title = "Sorry, you have not yet purchased airtime on Sidooh. Please do so in order to proceed.";
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
        error_log("Pre Agent: finalize");

        $type = SubscriptionType::whereAmount($this->vars['{$amount}'])->firstOrFail();

        $phoneNumber = $this->vars['{$my_number}'];
        $phone = $this->vars['{$number}'];
        $mpesa = $this->vars['{$mpesa_number}'];

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

        if ($method === PaymentMethods::MPESA)
            (new \App\Helpers\Sidooh\Subscription($type, $phoneNumber, $method))->purchase($phone, $mpesa);
        elseif ($acc->voucher->balance > $type->amount)
            (new \App\Helpers\Sidooh\Subscription($type, $phoneNumber, $method))->purchase($phone, $mpesa);
    }
}
