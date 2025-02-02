<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
            'registration_no' => 'required|string',
            'registration_date' => 'required|date',
            'property_category_id' => 'required|exists:property_categories,id',
            'owner_id' => 'required|exists:people,id',
            'is_active' => 'nullable|sometimes|boolean'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'property name'
        ];
    }
}
