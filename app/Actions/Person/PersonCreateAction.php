<?php

namespace App\Actions\Person;

use Exception;
use App\Models\Person;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PersonCreateAction
{
    public function execute(array $data)
    {
        return Person::updateOrCreate([
            'national_id' => $data['national_id']
        ], [
            ...$data,
        ]);
    }
}
