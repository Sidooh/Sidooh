<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\JWT;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @throws \Illuminate\Validation\ValidationException
     *@return bool
     *
     */
    public function login(Request $request): bool
    {
        $request->validate([
            "token" => "required|string",
            "user" => "required|array",
            "credentials" => "required|array:email,password"
        ]);

        Session::put('auth', $request->all());

        return Session::has('auth');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param array $credentials
     * @return bool
     */
    protected function attemptLogin(array $credentials)
    {
        $url = config('services.sidooh.services.accounts.api.url'). "/users/signin";

        $response = Http::acceptJson()->post($url, $credentials)->json();

        if(isset($response["errors"]) || !JWT::verify($response["token"])) return false;

        $user = JWT::decode($response["token"]);

        Session::put('user', $user);

        return true;
    }

    protected function authenticated(Request $request, $user): JsonResponse
    {
        return response()->json(["status" => true, "url" => route("admin.index")]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route("login");
    }

}
