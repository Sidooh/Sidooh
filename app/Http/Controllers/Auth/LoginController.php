<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {

//        Code to get timezone of user on login
        try {

            $client = new Client();

            $url = $request->ip() !== '127.0.0.1' ? 'http://ip-api.com/json/' . $request->ip() : 'http://ip-api.com/json';

            $ipInfo = $client->get($url);

            $timezone = json_decode($ipInfo->getBody())->timezone ?? 'Africa/Nairobi';

            session(['timezone' => $timezone]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

    }
}
