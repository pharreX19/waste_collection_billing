<?php

namespace App\Services;

use Ramsey\Uuid\Uuid;
use App\Models\Payable;
use Illuminate\Support\Str;
use Ramsey\Uuid\Rfc4122\UuidV5;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Constants\Payable as ConstantsPayable;
use App\Libraries\Traits\ProcessingPayableIdGenerator;

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
            $this->updatePayableState($payables);
            $tx = $this->createTransaction($payload, $token);
            return  $tx['data']['url'];
        }
        return null;
    }

    private function updatePayableState(array $payables)
    {
        $payable_ids = collect($payables)->pluck('payable_id')->toArray();
        Payable::whereIn('id', $payable_ids)->update(['state' => ConstantsPayable::PROCESSING]);
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
            "local_id" => (new ProcessingPayableIdGenerator())->generate($payables),
        ];
    }

    private function returnUrl()
    {
        return request()->headers->get('referer');
    }
}
