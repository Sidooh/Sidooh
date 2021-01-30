<?php


namespace App\Helpers\Sidooh\USSD\Processors;


use App\Helpers\Sidooh\USSD\Entities\PaymentMethods;
use App\Helpers\Sidooh\USSD\Entities\Screen;
use App\Models\UssdUser;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use libphonenumber\NumberParseException;
use Propaganistas\LaravelPhone\PhoneNumber;

class Product
{
    public int $phone;

    public Screen $screen;
    public Screen $previousScreen;

    public array $vars = array();
    /**
     * @var UssdUser
     */
    protected UssdUser $user;
    private string $sessionId;

    public function __construct(UssdUser $user, string $sessionId)
    {
        $this->sessionId = $sessionId;
        $this->phone = $user->phone;
        $this->vars['{$product}'] = $this->get_class_name();
        $this->vars['{$my_number}'] = $user->phone;
        $this->vars['{$pin_tries}'] = 3;

        $this->retrieveState();

        $this->saveState();
    }

    function get_class_name(string $class = null)
    {
        $classname = $class ?? get_class($this);

        if ($pos = strrpos($classname, '\\')) return substr($classname, $pos + 1);
        return $pos;
    }

    private function retrieveState()
    {
        try {
            $this->vars = json_decode(Storage::get($this->sessionId . '_vars.txt'), true);
        } catch (FileNotFoundException $e) {
            return null;
        }
    }

    private function saveState()
    {
        $contents = json_encode($this->vars);
        Storage::put($this->sessionId . '_vars.txt', $contents);
    }

    public function getSubProduct(UssdUser $user, string $sessionId, string $option)
    {
        return $this;
    }

    function validate_number(string $phone)
    {
        try {
            return PhoneNumber::make($phone, 'KE')->formatE164();
        } catch (NumberParseException $e) {
            return false;
        }
    }

    protected function process(UssdUser $user, Screen $previousScreen, Screen $screen)
    {
//        $this->user = $user;
        $this->retrieveState();

        $this->setScreens($previousScreen, $screen);

        $this->process_previous($previousScreen, $this->screen);

        $this->translateScreens();

        $this->saveState();

        if ($this->screen->type === "END" && $this->screen->key !== "cancel") {
            error_log("Finalizing..");
            $this->unsetState();
            $this->finalize();
        }

        return $this->screen;
    }

    /**
     * @param Screen $previousScreen
     * @param Screen $screen
     * @return Product
     */
    protected function setScreens(Screen $previousScreen, Screen $screen)
    {
        $this->previousScreen = $previousScreen;
        $this->screen = $screen;

        return $this;
    }

    protected function translateScreens()
    {
        foreach ($this->screen as $key => $value) {
            if (is_string($this->screen->$key)) {
                $this->screen->$key = strtr($this->screen->$key, $this->vars);
            } else if (is_array($value)) {
                foreach ($value as $vkey => $vvalue)
                    foreach ($vvalue as $okey => $ovalue)
                        if (is_string($ovalue))
                            $vvalue->$okey = strtr($vvalue->$okey, $this->vars);
            }
        }
    }

    private function unsetState()
    {
//        Storage::delete($this->sessionId . '_vars.txt');
    }

    /**
     * @param $value
     * @return mixed
     */
    protected function methods(int $value)
    {
        switch ($value) {
            case 1:
                return PaymentMethods::MPESA;
            case 2:
                return PaymentMethods::VOUCHER;
            case 3:
                return PaymentMethods::SIDOOH_POINTS;
            case 4:
                return PaymentMethods::SIDOOH_BONUS;
            default:
                return null;
        }
    }
}
