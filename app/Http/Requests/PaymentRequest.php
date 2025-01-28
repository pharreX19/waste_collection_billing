<?php

namespace App\Http\Requests;

use App\Models\Payable;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $payloadArray = request()->all();
        foreach ($payloadArray as $payload) {
            $payable = Payable::findOrFail($payload['payable_id']);
            $this->validatePayableState($payable);
            $this->validateAmount($payable, $payload['amount']);
        }
    }

    private function validatePayableState(Payable $payable)
    {
        if ($payable->state === 'paid') {
            throw ValidationException::withMessages([
                'payable' => 'No due amount found'
            ]);
        }

        if ($payable->payments->where('state', '!=', 'cancelled')->sum('amount') >= $payable->grand_total) {
            throw ValidationException::withMessages([
                'payable' => 'Payable completed'
            ]);
        }
    }


    private function validateAmount(Payable $payable, $amount)
    {
        $totalPaid = $payable->payments->where('state', '!=', 'cancelled')->sum('amount');
        $remainingAmount = $payable->grand_total - $totalPaid;

        if ($amount > $remainingAmount) {
            throw ValidationException::withMessages([
                'amount' => 'Amount is greater than the remaining amount'
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.payable_id' => 'required|exists:payables,id',
            '*.amount' => 'required|numeric|min:1',
            // 'state' => 'numeric',
            // 'payment_date' => 'required|datetime'
        ];
    }
}
