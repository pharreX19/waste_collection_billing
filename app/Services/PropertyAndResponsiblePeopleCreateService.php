<?php

namespace App\Services;

use App\Models\PersonProperty;
use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\Validator;
use App\Actions\Person\PersonCreateAction;
use App\Actions\Property\PropertyCreateAction;
use App\Models\PropertyCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class PropertyAndResponsiblePeopleCreateService
{
    public function execute($data)
    {
        $this->validateNIdIfNotAGovernmentProperty($data);

        $validated_data = $this->validate($data);
        $owner = $this->createOwner($validated_data['responsible_persons'][0]);

        $property = $this->createProperty([
            ...$data,
            'owner_id' => $owner->id
        ]);

        $responsible_people = [];
        foreach ($validated_data['responsible_persons'] as $person) {
            $responsible_person =  $this->createResponsiblePerson($person);
            $responsible_people[] = $responsible_person;
            $this->attachPersonToProperty($responsible_person, $property);
        }

        if (request()->method() === 'PUT') {
            $this->removePreviousResponsiblePeople($responsible_people,  $property);
        }
    }

    public function createOwner($data)
    {
        return (new PersonCreateAction())->execute($data);
    }

    public function createResponsiblePerson($person)
    {
        return (new PersonCreateAction())->execute($person);
    }

    public function attachPersonToProperty($responsible_person, $property)
    {
        return PersonProperty::firstOrCreate(
            [
                'responsible_person_id' => $responsible_person->id,
                'property_id' => $property->id
            ],
            [
                'id' => Ulid::generate(),
                'responsible_person_id' => $responsible_person->id,
                'property_id' => $property->id,
            ]
        );
    }

    function removePreviousResponsiblePeople($responsible_people, $property)
    {
        $peopleIds = collect($responsible_people)->pluck('responsible_person_id')->toArray();

        return PersonProperty::where('property_id', $property->id)
            ->whereNotIn('responsible_person_id', $peopleIds)
            ->delete();
    }


    public function createProperty($data)
    {
        return (new PropertyCreateAction())->execute($data);
    }


    function validate($data = [])
    {
        $validator = Validator::make($data, [
            'responsible_persons' => 'required|array',
            'responsible_persons.*.name' => 'required|string',
            'responsible_persons.*.national_id' => 'nullable|string|regex:/^A\d{6}$/',
            'responsible_persons.*.contact_no' => 'required|regex:/^\d{7}$/',
        ], [
            'responsible_persons.*.name.required' => 'ފުރިހަމަ ނަން ލިޔުއްވާ',
            'responsible_persons.*.name.string' => 'ނަމުގައި ތާނަ އަކުރު އެކަނި ބޭނުންކުރައްވާ',
            'responsible_persons.*.national_id.string' => 'އައިޑި ކާޑް ނަންބަރު ރަނގަޅެއް ނޫން',
            'responsible_persons.*.national_id.regex' => 'އައިޑި ކާޑް ނަންބަރު ރަނގަޅެއް ނޫން',
            'responsible_persons.*.contact_no.required' => 'ފޯން ނަންބަރު ލިޔުއްވާ',
            'responsible_persons.*.contact_no.regex' => 'ފޯން ނަންބަރު ރަނގަޅެއް ނޫން',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        return $validator->validated();
    }


    function validateNIdIfNotAGovernmentProperty($data)
    {
        $government_categories = Cache::remember('government_properties', 1440, function () {
            return PropertyCategory::where('is_government', 1)->pluck('id')->toArray();
        });

        $rules = ['responsible_persons.*.national_id' => 'required|string|regex:/^A\d{6}$/'];

        $messages = [
            'responsible_persons.*.national_id.required' => 'އައިޑި ކާޑް ނަންބަރު ލިޔުއްވާ',
            'responsible_persons.*.national_id.string' => 'އައިޑި ކާޑް ނަންބަރު ރަނގަޅެއް ނޫން',
            'responsible_persons.*.national_id.regex' => 'އައިޑި ކާޑް ނަންބަރު ރަނގަޅެއް ނޫން',
        ];


        if (in_array($data['property_category_id'], $government_categories)) {
            $rules['responsible_persons.*.national_id'] = [
                'sometimes',
                function ($attribute, $value, $fail) use ($data) {
                    preg_match('/\d+/', $attribute, $matches);

                    $index = $matches[0] ?? 0;
                    if ($index == 1 && empty($value)) {
                        return $fail('އައިޑީ ކާޑް ނަންބަރު ލިޔުއްވާ');
                    } else if ($index == 1 && !preg_match('/^A\d{6}$/', $value)) {
                        return $fail('އައިޑީ ކާޑް ނަންބަރު ރަނގަޅެއް ނޫން');
                    }
                },
            ];
        }

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
    }
}
