<?php

namespace App\Services;

use App\Constants\Payable;

class PayableStateMapping
{
    private $_stateLabels = [
        Payable::PAID => 'ފައިސާ ދައްކާފައި',
        Payable::PENDING => 'ފައިސާ ނުދައްކާ',
        Payable::CANCELLED => 'ކެންސަލް ކުރެވިފައި'
    ];

    public function handle(String $state)
    {
        return $this->_stateLabels[$state] ?? 'މުއްދަތު ހަމަވެފައި';
    }
}
