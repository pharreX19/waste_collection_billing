<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayableRequest extends FormRequest
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
            'viya_reference_no' => 'required|string|unique:payables,viya_reference_no'
        ];
    }

    public function messages()
    {
        return [
            'viya_reference_no.required' => 'ވިޔަ ޕޯޓަލްގެ ރެފަރެންސް ނަންބަރ ލިޔުއްވާ',
            'viya_reference_no.string' => 'ވިޔަ ޕޯޓަލްގެ ރެފަރެންސް ނަންބަރ ލިޔުއްވާ',
            'viya_reference_no.unique' => 'ތިޔަ ރެފަރެންސް ނަންބަރ ވަނީ ކުރިން ބޭނުންކޮށްފައި',
        ];
    }
}
