<?php

namespace App\Http\Requests;

use App\Models\Payable;
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
        $payable = Payable::findOrFail($this->payable_id);

        if ($payable->state === 'paid') {
            throw ValidationException::withMessages([
                'payable' => 'No due amount found'
            ]);
        }

        $total_paid = $payable->payments->where('state', '!=', 'cancelled')->sum('amount');
        $remaining_amount = $payable->grand_total - $total_paid;

        if ($this->amount > $remaining_amount) {
            throw ValidationException::withMessages([
                'amount' => 'Amount is greater than the remaining amount'
            ]);
        }

        if ($total_paid >= $payable->grand_total) {
            throw ValidationException::withMessages([
                'payable' => 'Payable completed'
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
            'payable_id' => 'required|exists:payables,id',
            'amount' => 'required|numeric|min:1',
            // 'state' => 'numeric',
            // 'payment_date' => 'required|datetime'
        ];
    }
}
