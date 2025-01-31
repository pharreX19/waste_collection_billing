<?php

namespace App\Actions\Auth;

use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginAction
{

    public function handle(array $data)
    {
        $credentials = [
            'mobile_no' => $data['mobile_no'],
            'otp' => $data['otp'],
        ];

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            if ($user->otp_expires_at < Carbon::now()) {
                throw new AuthenticationException('OTP expired');
            }

            return $this->setUserToken($user);
        }
        throw new AuthenticationException('Invalid credentials');
    }

    private function setUserToken($user)
    {
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();
        $user['token'] = $user->createToken('API TOKEN')->plainTextToken;

        return $user;
    }
}
