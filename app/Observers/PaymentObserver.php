<?php

namespace App\Observers;

use App\Constants\Payable;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentObserver
{
    /**
     * Handle the Payable "created" event.
     */
    public function created(Payment $payment): void
    {
        if ($payment->state === 'confirmed') {
            DB::transaction(function () use ($payment) {
                $payable = $payment->payable;
                $payable->balance = $payable->balance - $payment->amount;
                if ($payable->grand_total == $payable->payments()->sum('amount')) {
                    $payable->state = Payable::PAID;
                }
                $payable->save();
            });
        }
    }

    /**
     * Handle the Payable "updated" event.
     */
    public function updated(Payment $payment): void
    {
        // if ($payment->state === 'confirmed') {
        //     $payable = $payment->payable;
        //     $payable->decrement('grand_total', $payment->amount);
        // }
    }

    /**
     * Handle the Payable "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payable "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payable "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
