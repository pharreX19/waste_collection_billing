<?php

namespace App\Http\Controllers;

use App\Actions\Auth\OTPForLoginAction;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Constant\Role as ConstantRole;
use App\Constants\Role as ConstantsRole;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\OtpForLoginRequest;
use App\Http\Requests\PublicLoginRequest;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{
    protected $errorMessage = 'ތިޔަ ހޯއްދަވާ ޔޫޒަރ އެއް ނުފެނުނު';

    /**
     * Request an OTP for login.
     */
    public function getOtpForLogin(OtpForLoginRequest $request)
    {
        $user = (new OTPForLoginAction())->handle($request->all());
        return Inertia::render('Auth/Login', [
            'name' => $user->name,
            'property_id' => $user->property_id
        ]);
    }


    public function login(OtpForLoginRequest $request)
    {

        // TODO: Verify whether the passed property id belongs to user

        $user = User::where('name', $request->name)
            ->where('role_id', ConstantsRole::USER)
            ->where('is_active', 1)
            ->first();


        if (!$user) {
            throw ValidationException::withMessages([
                'name' => 'ތިޔަ ހޯއްދަވާ ޔޫޒަރ އެއް ނުފެނުނު'
            ]);
        }

        if (!Hash::check($request->otp, $user->otp) && $user->otp_expires_at > Carbon::now()) {
            return Inertia::render('Auth/Login', [
                'name' => $user->name,
                'property_id' => $request->property_id,
                'errors' => ['otp' => 'އޯޓީޕީ ރަނގަޅެއް ނޫން']
            ]);
        }


        Auth::login($user);

        $user->otp = null;
        $user->otp_expires_at = null;
        $user->otp_verified_at = now();

        $user->save();


        return to_route('payables.index', [
            'property' => $request->property_id,
            'year' => Carbon::now()->year
        ]);
    }


    public function adminLogin(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $remember = $request->has('remember');

            if (Auth::attempt($credentials, $remember) && Auth::user()->is_active && Auth::user()->role_id != ConstantsRole::USER) {
                return redirect('/');
            }

            Auth::logout();

            return redirect('/admin/login')->withErrors(['error' => $this->errorMessage]);
        } catch (\Exception $e) {
            return redirect('/admin/login')->withErrors(['error' => $this->errorMessage]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
