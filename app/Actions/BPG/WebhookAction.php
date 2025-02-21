<?php

namespace App\Actions\BPG;

use App\Jobs\ProcessPayment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Services\BPGVerificationService;
use Illuminate\Auth\Access\AuthorizationException;

class WebhookAction
{
    public function execute($data = [])
    {
        // if (!(new BPGVerificationService())->verifySignature(
        //     $data,
        //     request()->header("x-bpg-signature")
        // )) {
        //     Log::info('failed: Signature mismatch');
        //     throw new AuthorizationException('Unable to verify signature', Response::HTTP_FORBIDDEN);
        // }
        $this->processPayment($data);
    }


    private function processPayment($data)
    {
        return dispatch(new ProcessPayment($data));
    }
}
