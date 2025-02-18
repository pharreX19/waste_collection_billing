<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Constants\Role;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        return $this->merge([
            'role_id' => Role::OFFICER,
            'email_verified_at' => Carbon::now()
        ]);
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
            'email' => 'required|email|unique:users,email,' . $this->route('user')?->id,
            'password' => 'required_if:method,POST|string|min:5|max:20|confirmed',
            'password_confirmation' => 'required_with:password',
            'is_active' => 'sometimes|nullable|boolean',
            'role_id' => 'exists:roles,id',
            'email_verified_at' => 'sometimes|nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ފުރިހަމަ ނަން ލިޔުއްވާ',
            'name.string' => 'ފުރިހަމަ ނަން ލިޔުއްވާ',

            'email.required' => 'އީމެއިލް ލިޔުއްވާ',
            'email.email' => 'އީމެއިލް ރަނގަޅެއް ނޫން',
            'email.unique' => 'އީމެއިލް ވަނީ ކުރިން ރަޖިސްޓަރ ކޮށްފައި',

            'password_confirmation.required_with' => 'ޕާސްވާރޑް ލިޔުއްވާ',

            'password.required' => 'ޕާސްވާރޑް ލިޔުއްވާ',
            'password.confirmed' => 'ޕާސްވާރޑް އަދި ޕާސްވާރޑް ކޮންފަރމޭޝަން ދިމައެއް ނުވޭ',
            'password.string' => 'ޕާސްވާރޑް ލިޔުއްވާ',
            'password.min' => 'ޕާސްވާރޑްގެ ދިގުމިން އަދި ރަނގަޅެއްނޫން',
            'password.max' => 'ޕާސްވާރޑްގެ ދިގުމިން އަދި ރަނގަޅެއްނޫން'
        ];
    }
}
