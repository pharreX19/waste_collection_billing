<?php

namespace App\Constants;

use App\Constants\Constant;

class Payable extends Constant
{
    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const PAID = 'paid';
    const OVERDUE = 'overdue';
    const CANCELLED = 'cancelled';


    const PENDING_STATES = [
        'pending',
        'overdue'
    ];
}
