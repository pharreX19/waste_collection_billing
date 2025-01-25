<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ' ތިބޭފުޅާގެ އީމެއިލް އެޑްރެސް ލިޔުއްވާ',
            'password.required' => 'އެކައުންޓާއި ގުޅިފައިވާ ޕާސްވާރޑް ލިޔުއްވާ',

            'email.email' => 'އީމެއިލް ރަނގަޅެއްނޫން',
            'password.string' => 'ޕާސްވާރޑްގައި މައްސަލައެއް އެބައުޅޭ',
        ];
    }
}
