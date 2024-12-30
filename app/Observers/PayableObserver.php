<?php

namespace App\Observers;

use App\Models\Payable;

class PayableObserver
{
    /**
     * Handle the Payable "created" event.
     */
    public function created(Payable $payable): void
    {
        $this->saving($payable);
    }

    /**
     * Handle the Payable "updated" event.
     */
    public function updated(Payable $payable): void
    {
        $this->saving($payable);
    }

    /**
     * Handle the Payable "deleted" event.
     */
    public function deleted(Payable $payable): void
    {
        //
    }

    /**
     * Handle the Payable "restored" event.
     */
    public function restored(Payable $payable): void
    {
        //
    }

    /**
     * Handle the Payable "force deleted" event.
     */
    public function forceDeleted(Payable $payable): void
    {
        //
    }

    public function saving(Payable $payable)
    {
        $amount = $payable->amount;
        $fine = $payable->fine ?? 0;
        $discountPercentage = $payable->discount_percentage ?? 0;

        $discountAmount = $amount * ($discountPercentage / 100);

        $payable->grand_total = ($amount - $discountAmount) + $fine;
    }
}
