<?php

namespace App\Observers;

use App\Constants\Payable;
use App\Constants\Payment as ConstantsPayment;
use App\Models\Payable as ModelsPayable;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentObserver
{
    /**
     * Handle the Payable "created" event.
     */
    public function created(Payment $payment): void
    {
        $payable = $payment->payable;

        if ($payment->state === ConstantsPayment::CONFIRMED) {
            $this->handleConfirmedPayment($payable, $payment);
        } else if ($payment->state === ConstantsPayment::CANCELLED) {
            $this->handleCancelledPayment($payable);
        }
    }

    private function handleConfirmedPayment(ModelsPayable $payable, Payment $payment)
    {
        $payable->decrement('balance', $payment->amount);
        if ($payable->grand_total == $payable->payments()->sum('amount')) {
            $payable->update(['state' => Payable::PAID]);
        }
    }

    private function handleCancelledPayment(ModelsPayable $payable)
    {
        $payable->update(['state' => Payable::PENDING]);
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
