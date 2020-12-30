<?php


namespace App\Helpers\AfricasTalking;


use AfricasTalking\SDK\AfricasTalking;

class AfricasTalkingApi
{
    /**
     * Guzzle client initialization.
     *
     * @var AfricasTalking
     */
    protected $AT;

    /**
     * AfricasTalking APIs application mode.
     *
     * @var string
     */
    protected $mode;

    /**
     * AfricasTalking APIs application username.
     *
     * @var string
     */
    protected $username;

    /**
     * AfricasTalking APIs application key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Make the initializations required to make calls to the Safaricom MPESA APIs
     * and throw the necessary exception if there are any missing required
     * configurations.
     */
    public function __construct()
    {
        $this->mode = config('services.at.env');
    }

    private function initialize_app(string $app)
    {
//        TODO: Can this be done better in constructor instead of reinitializing?
        if ($this->mode == 'production') {
            $this->username = config("services.at.$app.username");
            $this->apiKey = config("services.at.$app.key");
        } else {
            $this->username = config('services.at.username');
            $this->apiKey = config('services.at.key');
        }

        $this->AT = new AfricasTalking($this->username, $this->apiKey);
    }

    public function sms($to, $message, $enqueue = false)
    {
        $this->initialize_app('sms');
        // Get sms service
        $sms = $this->AT->sms();

        // Use the service
        return $sms->send([
            'to' => $to,
            'message' => $message,
            'enqueue' => $enqueue
        ]);
    }

    public function airtime(string $to, string $amount, string $currency = 'KES')
    {
        $this->initialize_app('airtime');

        // Get airtime service
        $airtime = $this->AT->airtime();

        // Use the service
        return $airtime->send([
            'recipients' => [
                [
                    'phoneNumber' => $to,
                    'currencyCode' => $currency,
                    'amount' => $amount
                ],
            ]
        ]);

    }
}
