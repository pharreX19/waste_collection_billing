<?php

namespace App\Http\Controllers;

use App\Constant\Role as ConstantRole;
use App\Http\Requests\LoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    protected $errorMessage = 'ތިޔަ ހޯއްދަވާ ޔޫޒަރ އެއް ނުފެނުނު';


    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $remember = $request->has('remember');

            if (Auth::attempt($credentials, $remember) && Auth::user()->is_active) {
                return redirect('/');
            }

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
