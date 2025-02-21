<?php

namespace App\Services;

use Carbon\Carbon;

class BPGVerificationService
{

    public function verifySignature(array $payload, String $xBpgSignature): bool
    {
        [$signature, $timestamp] = $this->extractSignatureAndTimestamp($xBpgSignature);

        $data = "customer_reference=" . $payload['data']['customer_reference'] .
            "&id=" . $payload['data']['id'] .
            "&local_id=" . $payload['data']['local_id'] .
            "&state=" . $payload['data']['state'];

        $message = $timestamp . '.' .
            'created_at=' . $payload['created_at'] .
            '&data=' . $data .
            '&type=' . $payload['type'];


        $hash = str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode(
                hash_hmac('sha256', $message, config("payment.bpg.signing_secret"), true)
            )
        );


        if ($hash == $signature && $this->verifyTime($timestamp)) {
            return true;
        }
        return false;
    }



    private function extractSignatureAndTimestamp(String $value): array
    {
        $pattern = "/t=([\d]+),v1=([a-zA-Z0-9_\-\.]+)/";

        if (preg_match($pattern, $value, $matches)) {
            $timestamp = $matches[1];
            $signature = $matches[2];

            return [$signature, $timestamp];
        } else {
            return [];
        }
    }


    public function verifyTime(String $timestamp): bool
    {

        $date_time = Carbon::createFromTimestamp($timestamp)->addMinute();
        if ($date_time->greaterThanOrEqualTo(Carbon::now())) {
            return true;
        }
        return false;
    }
}
