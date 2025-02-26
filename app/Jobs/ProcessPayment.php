<?php

namespace App\Jobs;

use App\Models\Payable;
use App\Models\Payment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Constants\Payable as ConstantsPayable;

class ProcessPayment implements ShouldQueue
{
    use Queueable;

    private $_data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->_data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $payables = $this->getPayables();
        if ($payables) {
            foreach ($payables as $payable) {
                if ($payable && $payable['state'] === ConstantsPayable::PROCESSING) {
                    $this->createPayment($payable);
                }
            }
        }
        return;
    }

    private function getPayables()
    {
        $payable_ids = $this->retrieveCachePayablesIds();
        if (!$payable_ids) {
            return null;
        }

        return Payable::find(explode(',', $payable_ids))->toArray();
    }

    private function retrieveCachePayablesIds()
    {
        $cache_key = 'processing_payables: ' . $this->_data['local_id'];
        return Cache::get($cache_key);
    }

    private function createPayment($payable)
    {
        Payment::create([
            'payable_id' => $payable['id'],
            'amount' => $payable['grand_total'],
            'payment_date' => now(),
            'bpg_reference_id' => $this->_data['id'],
            'state' => strtolower($this->_data['state']),
        ]);
    }
}
