<?php


namespace App\Helpers\Sidooh\USSD;


use App\Helpers\Sidooh\USSD\Entities\ProductTypes;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Helpers\Sidooh\USSD\Processors\Account;
use App\Helpers\Sidooh\USSD\Processors\Agent;
use App\Helpers\Sidooh\USSD\Processors\AgentMain;
use App\Helpers\Sidooh\USSD\Processors\Airtime;
use App\Helpers\Sidooh\USSD\Processors\Merchant;
use App\Helpers\Sidooh\USSD\Processors\Pay;
use App\Helpers\Sidooh\USSD\Processors\Pre_Agent;
use App\Helpers\Sidooh\USSD\Processors\Product;
use App\Helpers\Sidooh\USSD\Processors\Referral;
use App\Helpers\Sidooh\USSD\Processors\Subscription;
use App\Helpers\Sidooh\USSD\Processors\Utility;
use App\Helpers\Sidooh\USSD\Processors\Voucher;
use App\Models\UssdState;
use App\Models\UssdUser;
use Error;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Karriere\JsonDecoder\JsonDecoder;
use libphonenumber\NumberParseException;
use Propaganistas\LaravelPhone\PhoneNumber;

class USSD
{
//    public User $user;

    public Screen $screen;
    public bool $break = false;
    /**
     * @var string
     */
    public string $initial;
    private array $screens;
    private Product $product;
    /**
     * @var UssdUser
     */
    private UssdUser $user;
    private string $sessionId;

    public function __construct(string $sessionId, UssdUser $user)
    {
        error_log("=============================");
        error_log("Begin");
        error_log("=============================");

        $this->sessionId = $sessionId;
        $this->init($user);
    }

    private function init(UssdUser $user)
    {
        $this->user = $user;
        $this->product = new Product($user, $this->sessionId);

        $jsonData = json_encode(json_decode(file_get_contents('data.json'), true));

        $jsonDecoder = new JsonDecoder();
        $jsonDecoder->register(new ScreenTransformer());

        $this->screens = $jsonDecoder->decodeMultiple($jsonData, Screen::class);

        $this->initial = $this->reset();
    }

    private function reset($home = false)
    {
        error_log('reset');

        $screen = $this->retrieveState();

        if ($screen instanceof Screen && !$home)
            $this->setScreen($screen, false);
        else {
            $acc = \App\Models\Account::wherePhone(ltrim($this->user->phone, '+'))->first();
            if ($acc->user) {
                $vars['{$name}'] = ' ' . explode(' ', $acc->user->name)[0];
            } else {
                $vars['{$name}'] = '';
            }

            $this->setScreen($this->screens['main_menu'], false);

            $this->screen->title = strtr($this->screen->title, $vars);

            if ($acc) {
                $voucherBalance = 'KSh' . number_format($acc->voucher->balance);
                $this->product->addVars('{$voucher_balance}', $voucherBalance);
            } else {
                $this->product->addVars('{$voucher_balance}', 0);
            }

        }

        return self::sendResponse($this->buildResponse());
    }

    private function retrieveState(): ?Screen
    {
        error_log("retrieveState");

//        try {
//            $contents = Storage::get($this->sessionId . '_state.txt');
//        } catch (FileNotFoundException $e) {
//            return null;
//        }

        try {
            $decodedData = UssdState::whereSession($this->sessionId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return null;
        }

//        try {
//            $contents = Redis::get($this->sessionId . '_state');
//        } catch (TypeError|RedisException $e) {
//            try {
//                $contents = Storage::get($this->sessionId . '_state.txt');
//            } catch (FileNotFoundException $e) {
//                return null;
//            }
//        }

//        $decodedData = json_decode($contents, true);

//        $this->setProduct($decodedData[0]);
//
//        $jsonData = json_encode($decodedData[1]);
        $this->setProduct($decodedData->ussd_product);

//        $jsonData = json_encode($decodedData->screen_path);

        $jsonDecoder = new JsonDecoder();
        $jsonDecoder->register(new ScreenTransformer());

        return $jsonDecoder->decode($decodedData->screen_path, Screen::class);
    }

    private function setProduct($value)
    {
//        error_log("---------------- Setting Product");
//        error_log($value);
//        error_log(ProductTypes::PAY_VOUCHER);
//        error_log($value == ProductTypes::PAY_VOUCHER);
//        error_log("---------------- ");
        switch ($value) {
            case ProductTypes::AIRTIME:
                $this->product = new Airtime($this->user, $this->sessionId);
                break;
            case ProductTypes::PAY:
                $this->product = new Pay($this->user, $this->sessionId);
                break;
            case ProductTypes::PAY_SUBSCRIPTION:
                $this->product = new Subscription($this->user, $this->sessionId);
                break;
            case ProductTypes::PAY_VOUCHER:
                $this->product = new Voucher($this->user, $this->sessionId);
                break;
            case ProductTypes::PAY_MERCHANT:
                $this->product = new Merchant($this->user, $this->sessionId);
                break;
            case ProductTypes::PAY_UTILITY:
                $this->product = new Utility($this->user, $this->sessionId);
                break;
            case ProductTypes::REFER:
                $this->product = new Referral($this->user, $this->sessionId);
                break;
            case ProductTypes::AGENT:
                $this->product = new AgentMain($this->user, $this->sessionId);
                break;
            case ProductTypes::PRE_AGENT_REGISTER:
                $this->product = new Pre_Agent($this->user, $this->sessionId);
                break;
            case ProductTypes::AGENT_REGISTER:
                $this->product = new Agent($this->user, $this->sessionId);
                break;
            case ProductTypes::ACCOUNT:
                $this->product = new Account($this->user, $this->sessionId);
                break;

        }
    }

    private function setScreen(Screen $screen, bool $keep_state = true)
    {
        if ($keep_state && "GENESIS" !== ($screen->type ?? false)) {
            $prev = $this->screen ?? null;
            $this->screen = $screen;
            $this->screen->previous = $prev;
        } else {
            $this->screen = $screen;
        }

        $this->saveState();
    }

    private function saveState()
    {
        error_log("saveState");
        $contents = json_encode($this->screen);
//        Storage::put($this->sessionId . '_state.txt', $contents);

        UssdState::updateOrCreate(
            ["session" => $this->sessionId],
            [
                "ussd_product" => $this->getProduct(true),
                "screen_path" => $contents
            ]);

//        try {
//            $contents = UssdState::whereSession($this->sessionId)->firstOrFail();
//        } catch (ModelNotFoundException $e) {
//            return null;
//        }

    }

    public function getProduct($as_enum = false)
    {
        if (!$as_enum)
            return $this->product;

//        error_log("---------------- Getting Product");
//        error_log($this->product instanceof Pay);
//        error_log($this->product instanceof Voucher);
//        error_log("---------------- ");

        if ($this->product instanceof Airtime)
            return ProductTypes::AIRTIME;
        else if ($this->product instanceof Pay) {
            if ($this->product instanceof Subscription)
                return ProductTypes::PAY_SUBSCRIPTION;
            else if ($this->product instanceof Voucher)
                return ProductTypes::PAY_VOUCHER;
            else if ($this->product instanceof Merchant)
                return ProductTypes::PAY_MERCHANT;
            else if ($this->product instanceof Utility)
                return ProductTypes::PAY_UTILITY;
            return ProductTypes::PAY;
        } else if ($this->product instanceof Referral)
            return ProductTypes::REFER;
        else if ($this->product instanceof AgentMain) {
            if ($this->product instanceof Pre_Agent)
                return ProductTypes::PRE_AGENT_REGISTER;
            else if ($this->product instanceof Agent)
                return ProductTypes::AGENT_REGISTER;
            return ProductTypes::AGENT;
        } else if ($this->product instanceof Account)
            return ProductTypes::ACCOUNT;

        return ProductTypes::DEFAULT;
    }

    static function sendResponse($message)
    {
        return $message;
    }

    /**
     * @return Screen
     */
    public function buildResponse(): string
    {
        error_log("buildResponse: " . $this->screen->type);
        if ($this->screen->type !== "END")
            $message = "CON ";
        else {
            $this->unsetState();
            $message = "END ";
        }

        $message .= $this->screen->title . PHP_EOL;

        if ($this->screen->type !== "END") {
            if (isset($this->screen->options))
                foreach ($this->screen->options as $key => $option) {
                    $message .= $option->value . ". " . $option->title . PHP_EOL;
                }

            if ($this->screen->previous && $this->screen->type !== "END") {
                $message = $this->addResponseFooter($message);
            }
        }

        return $message;
    }

    private function unsetState()
    {
        error_log("unsetState");
        Storage::delete($this->sessionId . '_state.txt');

        UssdState::whereSession($this->sessionId)->delete();
    }

    private function addResponseFooter($message)
    {
        $message .= PHP_EOL;
        if (!isset($this->screen->paginated))
            $message .= "0.Back ";
        $message .= "00.Home";

        return $message;
    }

    public function processUssd(UssdUser $user, $value)
    {
//        print_r('processing...');
        error_log("Chosen: " . $value . ' ' . $this->screen->type);

        if ($this->screen->type !== "GENESIS") {
            if ($value === "0") {
//                Solve issues with going back first
                $this->back();
            }
            if ($value === "00")
                $this->home();

        }

        if ($this->screen->type === "GENESIS")
            $this->setProduct($value);

//        if ($this->screen->super_product)
//            $this->setProduct(3 . $value);

        try {
            if ($this->screen->type !== "OPEN") {
                error_log("USSD:process - if not open");

                $option = $this->screen->findOption($value);

                if ($option) {
                    $this->screen->option = $option;
                    $screen = $this->findScreen($option->next);


//                    error_log("---------------- Super Product Option?");
//                    error_log(isset($screen->super_product));
//                    error_log(isset($this->screen->super_product));
//                    error_log(get_class($this->product));
//                    error_log(is_subclass_of($this->product, Product::class));
//                    error_log("----------------");
                    if (isset($this->screen->super_product))
                        $this->setProduct($this->screen->super_product . '.' . $value);
//                        $this->product = $this->product->getSubProduct($user, $this->sessionId, $this->screen->option->value);

//                  TODO: Before setting screen, pass to product e.g. Airtime(screen) to get back relevant vars.
                    if ($screen && is_subclass_of($this->product, Product::class, false) && !isset($screen->super_product)) {
//                        error_log("---------------- Product Subclass 2?");
//                        error_log(get_class($this->product));
//                        error_log("----------------");

                        $screen = $this->product ? $this->product->process($user, $this->screen, $screen) : $screen;
                    }

//                    error_log($screen);

                    if ($screen)
                        $this->setScreen($screen);
                }
            } else {
                error_log("USSD:process - else");

                $this->screen->option_string = $value;

                if ($this->validateOption($value)) {
                    $screen = $this->findScreen($this->screen->next);

                    if ($screen && is_subclass_of($this->product, Product::class, false)) {
                        $screen = $this->product ? $this->product->process($user, $this->screen, $screen) : $screen;
                    }
                }
//                else {
//                    $screen = $this->screen;
//                }
//
//                error_log($screen);

                if ($screen)
                    $this->setScreen($screen);

            }

        } catch (Error $e) {
            throw $e;
            $this->break = true;
            return null;
        }

        return self::sendResponse($this->buildResponse());
    }

    private function back()
    {
        error_log('back');

//        error_log("---------------- Going back?");
//        error_log($this->screen->previous->key);
//        error_log($this->screen->key);
//        error_log("----------------");

        if (isset($this->screen->previous))
            if ($this->screen->previous->type == "GENESIS")
                $this->reset(true);
            elseif (isset($this->screen->previous->option_type) && $this->screen->previous->option_type == "PIN")
                $this->setScreen($this->screen->previous->previous, false);
            else
                $this->setScreen($this->screen->previous, false);
        else
            $this->reset();


        return self::sendResponse($this->buildResponse());
    }

    public function home()
    {
        $this->reset(true);
    }

    private function findScreen($string): ?Screen
    {
//        print_r('screen searching...');

//        TODO: Search for ways to get screen without retrieving state
//        maybe pass the array from this class and search afresh?
//        keep original array separately? instead of clone...
        return array_key_exists($string, $this->screens) ? clone $this->screens[$string] : null;
    }

    private function validateOption(string $value)
    {
        error_log("Validating option");

        if (!isset($this->screen->option_type))
            return false;

        switch ($this->screen->option_type) {
            case "EMAIL":
                return $this->validate_email($value);
            case "NAME":
                return $this->validate_name($value);
            case "AMOUNT":
                return $this->validate_amount($value);
            case "MIN":
                return $this->validate_amount_min($value, 100);
            case "MIN|AIRTIME":
                return $this->validate_amount_min($value, 20);
            case "MIN|WITHDRAW":
                return $this->validate_amount_min($value, 20);
            case "PIN":
                return $this->validate_PIN($value);
            case "NUMBER":
                $phone = $this->validate_number($value);

                if ($phone != false && $phone != $this->validate_number($this->product->phone)) {
                    return true;
                }
                return false;
            case "MPESA":
                $phone = $this->validate_number($value);

                if ($phone != false && $phone != $this->validate_number($this->product->phone)) {
                    if (preg_match('(^(?:\+?254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$)', $phone))
                        return true;
                }
                return false;
            case "BUSINESS_NUMBER":
                return $this->validate_number($this->product->phone);
            case "MERCHANT_CODE":
                return $this->validate_merchant_code($value);
            default:
                return false;
        }
    }

    private function validate_number(string $phone)
    {
        try {
            return PhoneNumber::make($phone, 'KE')->formatE164();
        } catch (NumberParseException $e) {
            return false;
        }
    }

    private function validate_name(string $name)
    {
        return preg_match("/^[A-z ,.&'-]{3,}$/", $name);
    }

    private function validate_amount(string $amount)
    {
        return is_numeric($amount);
    }

    private function validate_amount_min(string $amount, int $min)
    {
        return is_numeric($amount) && (int)$amount >= $min;
    }

    private function validate_merchant_code(string $code)
    {
//        TODO: Should we check if merchant exists here? That will be an extra db call...
        return is_numeric($code);


//        return false;
    }

    private function validate_PIN(string $pin)
    {
//        error_log($pin);
//        error_log(is_numeric($pin));
//        error_log(strlen($pin));

        if (is_numeric($pin)) {
            return strlen(intval($pin)) == 4;
        }
        return false;
    }

    private function validate_email(string $email)
    {
        $regex = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        $regex = '/^(0000)|([a-z0-9\+_\-]{2,})(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]{2,}\.)+[a-z]{2,6}$/';

        return preg_match($regex, $email);
    }
}
