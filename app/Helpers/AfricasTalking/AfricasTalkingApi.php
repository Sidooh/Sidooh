<?php


namespace App\Helpers\AfricasTalking;


use GuzzleHttp\Exception\ServerException;

class AfricasTalkingApi
{
    /**
     * Guzzle client initialization.
     *
     * @var AfricasTalkingSubClass
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

        $this->AT = new AfricasTalkingSubClass($this->username, $this->apiKey);
    }

    public function sms($to, $message, $enqueue = false)
    {
        $this->initialize_app('sms');
        // Get sms service
        $sms = $this->AT->sms();

//        TODO: Should we add a try catch here to ensure message delivery or nah?

        try {
            // Use the service
            return $sms->send([
                'from' => config('services.at.sms.from'),
                'to' => $to,
                'message' => $message,
                'enqueue' => $enqueue
            ]);
        } catch (ServerException $e) {
//            TODO: Can we try send the message once more? and then should we throw error for sentry?
            $sms->send([
                'from' => config('services.at.sms.from'),
                'to' => ['254714611696', '254711414987'],
                'message' => "ERROR:SMS - Server error with AT",
                'enqueue' => $enqueue
            ]);

//            throw $e;
        } catch (\Exception $e) {
            $sms->send([
                'from' => config('services.at.sms.from'),
                'to' => ['254714611696', '254711414987'],
                'message' => "ERROR:SMS - Unidentified error with AT",
                'enqueue' => $enqueue
            ]);

//            throw $e;
        }

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

    public function transactionStatus(string $transactionId)
    {
        $this->initialize_app('airtime');

        // Get transaction service
        $transaction = $this->AT->transaction();

        // Use the service
        return $transaction->check([
            'transactionId' => $transactionId,
        ]);

    }
}
