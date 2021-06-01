<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helpers\Sidooh\USSD\Processors\Account;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Repositories\AccountRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|phone:KE',
            'password' => 'required|string',
        ]);

        $credentials = request(['username', 'password']);

        $acc = (new AccountRepository)->findByPhone($credentials['username']);

        if ($acc && $acc->user) {
            $credentials['email'] = $acc->user->email;

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('Personal Access Token')->accessToken;
                $cookie = $this->getCookieDetails($token);

                return response()
                    ->json([
                        'user' => $user,
                        'token' => $token,
                    ], 200);
//                    ->cookie($cookie['name'], $cookie['value'], $cookie['minutes'], $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly'], $cookie['samesite']);
            } else {
                return response()->json(
                    ['error' => 'invalid-credentials'], 422);
            }
        }

        return response()->json(
            ['error' => 'invalid-credentials'], 422);
    }

    private function getCookieDetails($token)
    {
        return [
            'name' => '_token',
            'value' => $token,
            'minutes' => 1440,
            'path' => null,
            'domain' => null,
            // 'secure' => true, // for production
            'secure' => null, // for localhost
            'httponly' => true,
            'samesite' => true,
        ];
    }


    public function checkPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|phone:KE',
        ]);

        $credentials = request(['phone']);

        $acc = (new AccountRepository)->findByPhone($credentials['phone']);

        if ($acc) {
            if ($acc->user) {
                return response()->json(
                    [
                        'status' => 'success',
                        'data' => $acc,
                    ]
                );
            }
//
//            return response()->json(
//                ['error' => 'invalid-credentials']
//            );
        }

        return response()->json(
            ['message' => 'No account with this phone number exists'], 404);
    }
}
