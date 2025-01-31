<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicLoginRequest extends FormRequest
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
            'name' => 'required|string',
            'otp' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ތިބޭފުޅާގެ ގޭގެ ނަން ނުވަތަ ރަޖިސްޓްރީ ކޯޑް ލިޔުއްވާ',
            'otp.required' => 'ފޯނަށް ލިބޭ އޯޓީޕީ ކޯޑް ލިޔުއްވާ',

            'name.string' => 'ގޭގެ ނަން ނުވަތަ ރަޖިސްޓްރޭޝަން ކޯޑް ރަނގަޅެއްނޫން',
            'otp.string' => 'އޯޓީޕީ ކޯޑް ރަނގަޅެއްނޫން',
        ];
    }
}
