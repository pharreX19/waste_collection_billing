<?php

namespace App\Http\Controllers;

use App\Actions\BPG\WebhookAction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BPGWebhookController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $payload = $request->all();

        $validation_rules = [
            "id" => 'required|string',
            "local_id" => 'required|string',
            "customer_reference" => 'required|string',
            // "state" => "required|string|in:CONFIRMED",
        ];

        $validator = Validator::make($payload['data'], $validation_rules);

        if ($validator->failed()) {
            throw new ValidationException($validator);
        }

        if ($payload['data']['state'] === 'PP_TRANSACTION_GENERATED') {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        return (new WebhookAction())->execute($payload);
    }
}
