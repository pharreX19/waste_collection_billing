<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Payable;
use App\Models\Setting;
use Illuminate\Console\Command;
use App\Constants\Payable as ConstantsPayable;
use App\Constants\Setting as ConstantsSetting;

class CalculateFines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payables:calculate-fines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apply fines to overdue payables without payments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Calculating fines for overdue payables...');
        $fine_amount = (float) Setting::where('key', ConstantsSetting::FINE_AMOUNT)->value('value');

        $overduePayables = Payable::withoutGlobalScope('userPayable')
            ->whereIn('state', [ConstantsPayable::PENDING])
            ->where('due_date', '<', Carbon::now())
            ->where('fine', '=', 0)
            ->where('balance', '>', 0)
            ->get();


        if ($overduePayables->isEmpty()) {
            $this->info('No overdue payables found.');
            return Command::SUCCESS;
        }

        $updatedPayables = $overduePayables->each(function ($payable) use ($fine_amount) {
            $payable->increment('fine', $fine_amount);
            $payable->increment('balance', $fine_amount);
            $payable->increment('grand_total', $fine_amount);
            $payable->state = ConstantsPayable::OVERDUE;
            $payable->save();
        });

        $this->info("Fine applied and state updated for " . $updatedPayables->count() . " payables.");

        return Command::SUCCESS;
    }
}
