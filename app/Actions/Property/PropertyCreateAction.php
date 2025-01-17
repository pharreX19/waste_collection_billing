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
        return Property::create($validated_data);
    }


    public function validate($data = [])
    {
        $validator = Validator::make(
            $data,
            (new PropertyRequest())->rules(),
            [],
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
