<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\AccountRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'phone' => 'required|string|phone:KE',
            'password' => 'required|string',
        ]);

        $phone = $request->phone;
        $credentials = request(['password']);

        $acc = (new AccountRepository)->findByPhone($phone);

        if ($acc && $acc->user) {
            $credentials['email'] = $acc->user->email;

//                TODO: Possibly check if password is equivalent to $this->vars['{$email}'] . '5!D00h'; If so, user has not logged in before, redirect to register
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('JWT')->accessToken;
//                $cookie = $this->getCookieDetails($token);

                return response()
                    ->json([
                        'account' => $acc,
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

    public function register(Request $request)
    {
        $acc = (new AccountRepository)->findByPhone($request->phone);

        $request->validate([
            'phone' => 'required|string|phone:KE',
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users' . ($acc->user ? ',id,' . $acc->user->id : null),
            'password' => 'required|string|min:8|confirmed',
        ]);

        $credentials = request(['phone', 'name', 'email', 'password']);
        $credentials['password'] = Hash::make($credentials['password']);

        $acc = (new AccountRepository)->findByPhone($credentials['phone']);

        if ($acc) {

            if ($user = $acc->user) {
//                Modify user
                $user->update($credentials);

            } else {
//                Create user
                $credentials['id_number'] = $credentials['email'];
                $credentials['username'] = $credentials['email'];

                $user = User::create($credentials);

                $acc->user()->associate($user);
                $acc->save();
            }

            return response()
                ->json([
                    'status' => 'SUCCESS',
                    'user' => $user,
                ]);

        } else {
            return response()->json(
                [
                    'status' => 'ERROR',
                    'message' => 'No account with this phone number exists'
                ], 404);
        }
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
            $otp = $this->sendOtp($acc);

//            TODO: Use otp library instead of session, someone can just check network tab
            if ($acc->user) {
//                TODO: Possibly check if password is equivalent to $this->vars['{$email}'] . '5!D00h'; If so, user has not logged in before
                return response()->json(
                    [
                        'status' => 'SUCCESS',
                        'data' => [
                            'acc' => $acc,
                            'otp' => $otp,
                        ]
                    ]
                );
            }

//            TODO: Consider if acc exists but no user exists
//
//            return response()->json(
//                ['error' => 'invalid-credentials']
//            );
        }

        return response()->json(
            [
                'status' => 'ERROR',
                'message' => 'No account with this phone number exists'
            ], 404);
    }

    private function sendOtp($acc)
    {
        $otp = mt_rand(100000, 999999);

        $message = "$otp is your Sidooh Verification code.";

//        TODO: Check OTP sent and return success or failure.
//
        (new AfricasTalkingApi())->sms([$acc->phone], $message);

        return $otp;
    }
}
