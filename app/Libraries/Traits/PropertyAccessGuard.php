<?php

namespace App\Libraries\Traits;

use App\Constants\Role;

trait PropertyAccessGuard
{
    public function ensureUserIsResponsible($property)
    {
        if (auth()->user()->role_id === Role::USER && !$this->userIsResponsibleForProperty($property)) {
            abort(403);
        }
    }

    private function userIsResponsibleForProperty($property)
    {
        return $property->responsiblePersons->contains('id', auth()->user()->person_id);
    }
}
