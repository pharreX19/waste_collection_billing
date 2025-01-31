<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Constant\Role as ConstantRole;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\OtpForLoginRequest;
use App\Http\Requests\PublicLoginRequest;

class AuthController extends Controller
{
    protected $errorMessage = 'ތިޔަ ހޯއްދަވާ ޔޫޒަރ އެއް ނުފެނުނު';

    /**
     * Request an OTP for login.
     */
    public function getOtpForLogin(OtpForLoginRequest $request)
    {
        return response()->json((new Log));
    }


    public function publicLogin(PublicLoginRequest $request)
    {
        try {
            $credentials = $request->only('name', 'otp');

            if (Auth::attempt($credentials) && Auth::user()->is_active) {
                return redirect('/');
            }

            return redirect('/login')->withErrors(['error' => $this->errorMessage]);
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => $this->errorMessage]);
        }
    }


    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $remember = $request->has('remember');

            if (Auth::attempt($credentials, $remember) && Auth::user()->is_active && Auth::user()->role_id == ConstantRole::OFFICER) {
                return redirect('/');
            }

            Auth::logout();

            return redirect('/login')->withErrors(['error' => $this->errorMessage]);
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => $this->errorMessage]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
