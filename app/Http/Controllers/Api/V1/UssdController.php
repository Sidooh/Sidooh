<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Http\Controllers\Controller;
use App\Repositories\NotificationRepository;
use App\Repositories\UssdRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class UssdController extends Controller
{
    //

    protected $ussd;


    /**
     * UssdController constructor.
     *
     * @param UssdRepository $ussd
     */
    public function __construct(UssdRepository $ussd)
    {
        $this->ussd = $ussd;
    }


    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        //
//        $this->ussd->processAirtimeUSSD();
//        return new UssdRepository($this->ussd->process());
//        'END Thank you for reaching out.';
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function ussd()
    {
        //
        $this->ussd->processRefactored();
//        return new UssdRepository($this->ussd->process());
//        'END Thank you for reaching out.';
    }

    /**
     * Test sending of sms
     *
     * @return array
     */
    public function sms()
    {
        return NotificationRepository::sendSMS(request()->recipients, request()->message);
    }

    /**
     * Test purchase of airtime
     *
     * @return string
     */
    public function airtime()
    {

        return (new AfricasTalkingApi())->airtime(request()->phone, 5);

    }

    /**
     * Test status of transaction
     *
     * @return string
     */
    public function transaction()
    {

        return json_encode((new AfricasTalkingApi())->transactionStatus('ATQid_da73e457651f560e415b36f17a61817d'));

    }

    /**
     * Test stk push
     *
     * @return string
     */
    public function stk()
    {

        return mpesa_request(request()->phone, 5, '000-TEST', "STK Test");

    }

    /**
     * Test stk push
     *
     * @return string
     */
    public function b2c()
    {

        $b2c = mpesa_send(request()->phone, request()->amount, "B2C Test 2");

        return $b2c;
    }

    /**
     * @param string|null $initiator
     * @return \Illuminate\Http\JsonResponse
     */
    public function b2cResult($initiator = null): \Illuminate\Http\JsonResponse
    {
        Log::info(request());

        $this->ussd->handleResult($initiator);
        return response()->json(
            [
                'ResponseCode' => '00000000',
                'ResponseDesc' => 'success'
            ]
        );
    }

    public function setUtilitiesProvider(string $provider, Request $request): array
    {
        $array = Config::get('services');

        $array['sidooh']['utilities_provider'] = strtoupper($provider);

        $data = var_export($array, 1);
        if (File::put(config_path() . '/services.php', "<?php\n return $data ;")) {
            // Successful, return Redirect...

            return [
                "provider" => config('services.sidooh.utilities_provider')
            ];
        }

        return ['error' => 'Could not update file'];
    }

    public function getUtilitiesProvider(Request $request): array
    {
        return [
            "provider" => config('services.sidooh.utilities_provider')
        ];

    }

    public function enableUtilities(Request $request): array
    {
        $currentConfig = config('services.sidooh.utilities_enabled');

        $array = Config::get('services');

        $array['sidooh']['utilities_enabled'] = !$currentConfig;

        $data = var_export($array, 1);
        if (File::put(app_path() . '/../config/services.php', "<?php\n return $data ;")) {
            // Successful, return Redirect...

            return [
                "utilities_enabled" => config('services.sidooh.utilities_enabled')
            ];
        }

        return ['error' => 'Could not update file'];
    }

    public function getUtilitiesStatus(Request $request)
    {
        return [
            "utilities_enabled" => config('services.sidooh.utilities_enabled')
        ];
    }

    public function enableSmsProvider(Request $request): array
    {
        $currentConfig = config('services.sidooh.services.notify.enabled');

        $array = Config::get('services');

        $array['sidooh']['services']['notify']['enabled'] = !$currentConfig;

        $data = var_export($array, 1);
        if (File::put(app_path() . '/../config/services.php', "<?php\n return $data ;")) {
            // Successful, return Redirect...

            return [
                "notify.enabled" => config('services.sidooh.services.notify.enabled')
            ];
        }

        return ['error' => 'Could not update file'];
    }

    public function getSmsProviderStatus(Request $request): array
    {
        return [
            "notify.enabled" => config('services.sidooh.services.notify.enabled')
        ];

    }
}
