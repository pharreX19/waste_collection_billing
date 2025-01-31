<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtpForLoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'contact_no' => ['required', 'numeric', 'regex:/\d{7}$/']
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'ތިބޭފުޅާގެ ގޭގެ ނަން ނުވަތަ ރަޖިސްޓްރީ ކޯޑް ލިޔުއްވާ',
            'contact_no.required' => 'ތިބޭފުޅާގެ ފޯން ނަންބަރ ލިޔުއްވާ',

            'name.string' => 'ގޭގެ ނަން ނުވަތަ ރަޖިސްޓްރޭޝަން ކޯޑް ރަނގަޅެއްނޫން',
            'contact_no.required' => 'ފޯން ނަންބަރ ރަނގަޅެއް ނޫން',
        ];
    }
}
