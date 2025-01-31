<?php

namespace App\Jobs;

use App\Services\SmsNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOtpSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $mobile_no;
    protected string $otp;
    private string $app;

    /**
     * Create a new job instance.
     */
    public function __construct(string $mobile_no, string $otp, string $app)
    {
        $this->mobile_no = $mobile_no;
        $this->otp = $otp;
        $this->app = $app;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $code = '';

        $message = "Your One-Time Password (OTP) is: $this->otp.\n This code is valid for 5 minutes.\n Please do not share this code with anyone.\n $code";

        (new SmsNotificationService())->send($this->mobile_no, $message);
    }
}
