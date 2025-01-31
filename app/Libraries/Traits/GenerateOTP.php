<?php

namespace App\Libraries\Traits;

use App\Constants\OTP;

trait GenerateOTP
{
    private $_otp;


    public function setOTP()
    {
        $this->_otp = '000000'; ///rand(OTP::OTP_MIN_INT, OTP::OTP_MAX_INT);

        return $this;
    }

    public function getOTP()
    {
        return $this->_otp;
    }
}
