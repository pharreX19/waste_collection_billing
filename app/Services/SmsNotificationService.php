<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsNotificationService
{
    public function send(string $mobileNo, string $message): void
    {
        if (!config('services.msgowl.active')) {
            return;
        }

        try {
            $response = Http::baseUrl(config('services.msgowl.url'))
                ->withHeaders([
                    'Authorization' => 'AccessKey ' . config('services.msgowl.access_key'),
                    'Accept' => 'application/json',
                ])
                ->asJson()
                ->post('messages', [
                    'recipients' => $mobileNo,
                    'body' => $message,
                    'sender_id' => config('services.msgowl.sender'),
                ]);
        } catch (Exception $exception) {
            Log::alert('message owl fail', [$exception->getMessage()]);
        }
    }
}
