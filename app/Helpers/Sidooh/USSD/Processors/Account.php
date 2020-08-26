<?php


namespace App\Helpers\Sidooh\USSD\Processors;

use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Model\User;
use App\Models\UssdUser;
use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Hash;

class Account extends Product
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
        error_log('PROCESS_PREVIOUS');
        error_log($previousScreen->key);

        switch ($previousScreen->key) {
            case "main_menu":
                $this->set_user_number();
                break;
            case "account":
                if ($screen->key == 'redeem_amount') {
                    $this->check_earnings($previousScreen);
                } else {
                    $this->set_kyc_details();
                }
                break;
            case "kyc_details_name":
                $this->set_name($previousScreen);
                break;
            case "kyc_details_mail":
                $this->set_email($previousScreen);
                break;
            case "kyc_details_new_pin":
                $this->set_pin($previousScreen);
                break;
            case "kyc_details_new_pin_confirm":
                $this->set_pin_confirm($previousScreen);
                break;

            case "kyc_details_current_pin":
                $this->check_current_pin($previousScreen);
                break;

            case "confirm_pin":
                $this->set_earnings($previousScreen);
                break;

            case 'redeem_amount':
                $this->set_points($previousScreen);
                break;
            case 'redeem_account':
                $this->set_account_type($previousScreen);
                break;
            case 'redeem_account_select':
                $this->set_number($previousScreen);
                break;
            case "other_number_mpesa":
                $this->set_mpesa_number($previousScreen);
                break;

        }
    }

    private function set_user_number()
    {
        $this->vars['{$product}'] = $this->get_class_name();
        $this->vars['{$my_number}'] = $this->phone;
    }


    private function set_kyc_details()
    {
        $res = (new AccountRepository)->findByPhone($this->phone);

        if ($res)
            if ($res->user_id) {
                $user = $res->user;

                $this->vars['{$name}'] = $user->name;
                $this->vars['{$email}'] = $user->email;
            } else {
                $this->vars['{$name}'] = "";
                $this->vars['{$email}'] = "";
            }
        else {
            $this->screen->title = "Sorry, but you have not transacted on Sidooh previously. Please do so in order to access your account.";
            $this->screen->type = 'END';
        }

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

    private function set_pin(Screen $previousScreen)
    {
        $this->vars['{$pin}'] = $previousScreen->option_string;
    }

    private function set_pin_confirm(Screen $previousScreen)
    {
        if ($previousScreen->option_string === $this->vars['{$pin}']) {
            $this->vars['{$confirm_pin}'] = $previousScreen->option_string;
        } else {
            $this->screen->title = "PINs don't match\n Please try again.";
        }
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

    private function set_earnings(Screen $previousScreen)
    {
        $acc = $this->check_current_pin($previousScreen);

        if ($acc) {
            $bal = $acc->sub_account->balance;

            $this->vars['{$spb}'] = $bal;
            $this->vars['{$sbb}'] = 0;
            $this->vars['{$wb}'] = $bal > 30 ? $bal - 30 : 0;

        }

    }

    private function check_earnings(Screen $previousScreen)
    {
        $acc = (new AccountRepository)->findByPhone($this->phone);

        if ($acc)
            if ($acc->pin) {
                $bal = $acc->sub_account->balance;

                $this->vars['{$spb}'] = $bal;
                $this->vars['{$sbb}'] = 0;
                $this->vars['{$wb}'] = $bal > 30 ? $bal - 30 : 0;

                if ($this->vars['{$wb}'] == 0) {
                    $this->screen->title = "Sorry but your Withdrawable Balance is 0";
                    $this->screen->type = 'END';
                }

            } else {
                $this->screen->title = "Sorry, but you have not set a pin. Please do so in order to be able to proceed.";
                $this->screen->type = 'END';
            }

        else {
            $this->screen->title = "Sorry, but you have not transacted on Sidooh previously. Please do so in order to access your account.";
            $this->screen->type = 'END';
        }

    }

    private function set_points(Screen $previousScreen)
    {
        $this->vars['{$points}'] = $previousScreen->option_string;
        $this->vars['{$amount}'] = $previousScreen->option_string;
    }

    private function set_account_type(Screen $previousScreen)
    {
        $method = $this->methods($previousScreen->option->value);
        $this->vars['{$acc_type}'] = $method;
    }

    private function set_number(Screen $previousScreen)
    {
        if ($previousScreen->option->value == 1)
            $this->vars['{$to_number}'] = $this->vars['{$my_number}'];
    }

    private function set_mpesa_number(Screen $previousScreen)
    {
        $this->vars['{$mpesa_number}'] = $previousScreen->option_string;
    }

    protected function finalize()
    {
//        TODO: Finalize transaction
        error_log("Account: finalize");

        if ($this->previousScreen->key == 'account' || $this->previousScreen->key == 'kyc_details_current_pin' || $this->previousScreen->key == 'earnings')
            return;

        if ($this->screen->key == 'kyc_details_pin_end') {
            $this->set_pin_and_user();
        }

    }

    private function set_pin_and_user()
    {
        $phone = $this->vars['{$my_number}'];
//
        $name = $this->vars['{$name}'];
        $email = $this->vars['{$email}'];
        $pass = $this->vars['{$email}'] . '5!D00h';
        $pin = $this->vars['{$confirm_pin}'];

        $acc = (new AccountRepository)->findByPhone($this->phone);

//        $acc->pin = Hash::make($pin);
        $acc->pin = $pin;

        $user = $acc->user;

        if (!$acc->user)
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
    }

}
