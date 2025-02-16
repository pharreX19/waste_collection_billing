<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:users,email,' . $this->route('user')?->id,
            'description' => 'sometimes|nullable|string|max:255',
            'service_fee' => 'required|numeric|min:1|max:9999',
            'is_government' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ކެޓަގަރީގެ ނަން ލިޔުއްވާ',
            'name.string' => 'ކެޓަގަރީގެ ނަން ލިޔުއްވާ',

            'description.max' => 'ކެޓަގަރީގެ ތަފްޞީލު ޚުލާސާ ކުރައްވާ',

            'service_fee.required' => 'ކެޓަގަރީގެ މަހު ފީ ލިޔުއްވާ',
            'service_fee.min' => 'ކެޓަގަރީގެ މަހު ފީ ރަނގަޅެއްނޫން',
            'service_fee.max' => 'ކެޓަގަރީގެ މަހު ފީ ރަނގަޅެއްނޫން',

            'is_government.required' => 'ކެޓަގަރީއަކީ ސަރުކާރުގެ އިދާރާތަކާއި ގުޅުންހުރި ކެޓަގަރީއެއްތޯ',
        ];
    }
}
