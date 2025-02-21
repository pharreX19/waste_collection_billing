<?php

namespace App\Services;

use App\Models\Payable;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    const MINOR_UNIT_CONVERSION_RATE = 100;
    const HEADERS = [
        "Content-type" => "application/json",
        "X-BPG-API" => "v1",
    ];

    public function pay(array $payables = [])
    {
        $payload = $this->prepare($payables);
        $response = $this->login();

        if ($token = $response["access_token"]) {
            $tx = $this->createTransaction($payload, $token);
            return  $tx['data']['url'];
        }
        return null;
    }


    private function login()
    {
        return Http::timeout(5)
            ->acceptJson()
            ->post(config("services.bpg.base_url") . "/token", [
                "client_id" => config("services.bpg.client_id"),
                "client_secret" => config("services.bpg.client_secret"),
            ])
            ->throw()
            ->json();
    }

    private function createTransaction($data, $token)
    {
        return Http::timeout(5)
            ->withToken($token)
            ->withHeaders(self::HEADERS)
            ->acceptJson()
            ->post(config("services.bpg.base_url") . "/transactions", $data)
            ->throw()
            ->json();
    }

    private function prepare($payables)
    {
        $purposes = array_map(function ($payable) {
            return [
                "local_id" => $payable['payable_id'],
                'local_code' => '549103MAF',
                "amount" => (int) $payable['amount'] * self::MINOR_UNIT_CONVERSION_RATE,
            ];
        }, $payables);


        $customer = [
            "type" => "Individual Local",
            "id" => '1234567890123',
            "name" => 'Test User',
        ];

        return [
            "customer" => $customer,
            "currency" => "MVR",
            "purposes" => $purposes,
            "return_url" => $this->returnUrl(),
            // "customer_reference" => (string) $invoice->payer_uuid,
            // "local_id" => (string) $invoice->uuid,
            // "total_amount" => $this->convertCurrencyToMvr($amount, $invoice),
        ];
    }

    private function returnUrl()
    {
        return config("payment.bpg.redirect_url");
    }
}
