<?php

namespace App\Actions\Property;

use Exception;
use App\Models\Property;
use App\Http\Requests\PropertyRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PropertyCreateAction
{
    public function execute($data)
    {
        $validated_data = $this->validate($data);

        return Property::updateOrCreate(
            [
                'registration_no' => $data['registration_no']
            ],
            $validated_data
        );
    }


    public function validate($data = [])
    {
        $validator = Validator::make(
            $data,
            (new PropertyRequest())->rules(),
            [
                'name.required' => 'ގޭބިސީގެ ނަން ލިޔުއްވާ',
                'name.string' => 'ގޭބިސީގެ ނަމުގައި ހަމައެކަނި ތާނަ އަކުރު ލިޔުއްވާ',
                'registration_no.required' => 'ގޭބިސީގެ ރަޖިސްޓްރޭޝަން ނަންބަރު ލިޔުއްވާ',
                'registration_no.string' => 'ގޭބިސީގެ ރަޖިސްޓްރޭޝަން ނަންބަރުގައި ހަމައެކަނި ތާނަ އަކުރު ލިޔުއްވާ',
                'property_category_id.required' => 'ގޭބިސީގެ ކެޓަގަރީ އިޚްތިޔާރު ކުރައްވާ',
                'property_category_id.exists' => 'އިޚްތިޔާރުކުރެއްވި ގޭބިސީގެ ކެޓަގަރީ ރަނގަޅެއް ނޫން',
                'owner_id.required' => 'ގޭބިސީގެ ޒިންމާދާރުވެރި ފަރާާތުގެ ނަން ލިޔުއްވާ',
                'owner_id.exists' => 'އިޚްތިޔާރު ކުރެއްވި ޒިންމާދާރުވެރި ފަރާތް ރަނގަޅެއްނޫން',
            ],
            [
                'name' => 'property name'
            ]
        );

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        return $validator->validated();
    }
}
