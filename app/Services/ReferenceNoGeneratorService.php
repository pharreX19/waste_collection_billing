<?php

namespace App\Services;

use App\Models\Payable;
use Carbon\Carbon;

class ReferenceNoGeneratorService
{
    /**
     * Generate a unique invoice reference number.
     *
     * Format: INV-MM-YYYY-Sequence
     *
     * @return string
     */
    public function generate()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->year;

        $lastInvoice = Payable::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextSequence = $lastInvoice ? intval(substr($lastInvoice->receipt_no, -4)) + 1 : 1;

        $sequence = str_pad($nextSequence, 4, '0', STR_PAD_LEFT);

        return "INV-{$month}-{$year}-{$sequence}";
    }
}
