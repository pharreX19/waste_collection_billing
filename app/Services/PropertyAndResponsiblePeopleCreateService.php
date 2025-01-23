<?php

namespace App\Services;

use App\Models\PersonProperty;
use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\Validator;
use App\Actions\Person\PersonCreateAction;
use App\Actions\Property\PropertyCreateAction;
use Illuminate\Validation\ValidationException;

class PropertyAndResponsiblePeopleCreateService
{
    public function execute($data)
    {
        $validated_data = $this->validate($data);
        $owner = $this->createOwner($validated_data['responsible_persons'][0]);

        $property = $this->createProperty([
            ...$data,
            'owner_id' => $owner->id
        ]);

        return $this->createResponsiblePeople($validated_data['responsible_persons'], $property);
    }

    public function createOwner($data)
    {
        return (new PersonCreateAction())->execute($data);
    }

    public function createResponsiblePeople($people, $property)
    {
        $responsible_people = [];
        foreach ($people as $person) {
            $responsible_person = (new PersonCreateAction())->execute($person);

            $responsible_people[] = PersonProperty::firstOrCreate(
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

        if (request()->method() === 'PUT') {
            $this->removePreviousResponsiblePeople($responsible_people,  $property);
        }
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
            'responsible_persons.*.national_id' => 'required|regex:/^A\d{6}$/',
            'responsible_persons.*.contact_no' => 'required|regex:/^\d{7}$/',
            'responsible_persons.*.address' => 'required|string'
        ], [], [
            'responsible_persons.*.national_id' => 'responsible person national id',
            'responsible_persons.*.name' => 'responsible person name',
            'responsible_persons.*.contact_no' => 'responsible person contact no',
            'responsible_persons.*.address' => 'responsible person address'
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        return $validator->validated();
    }
}
