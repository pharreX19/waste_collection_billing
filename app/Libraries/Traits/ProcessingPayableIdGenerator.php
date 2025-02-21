<?php

namespace App\Libraries\Traits;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class ProcessingPayableIdGenerator
{
    public function generate($payable = [])
    {
        $bpg_local_id = $this->generateUniqueId();
        $this->cachePayables($payable, $bpg_local_id);
        return $bpg_local_id;
    }

    private function generateUniqueId(): string
    {
        return Uuid::uuid4()->toString();
    }

    private function cachePayables($payables, $bpg_local_id)
    {
        $cache_key = 'processing_payables: ' . $bpg_local_id;
        $payable_ids = $this->extractPayableIds($payables);
        Cache::put($cache_key, $payable_ids, now()->addMinutes(5));
    }

    private function extractPayableIds(array $payables): string
    {
        return collect($payables)->pluck('payable_id')->join(',');
    }
}
