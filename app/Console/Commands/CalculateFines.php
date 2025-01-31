<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payable;
use Carbon\Carbon;

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

        $overduePayables = Payable::withoutGlobalScope('userPayable')
            ->where('state', 'pending')
            ->where('due_date', '<', Carbon::now())
            ->whereDoesntHave('payments')
            ->where('fine', '=', 0)
            ->get();


        if ($overduePayables->isEmpty()) {
            $this->info('No overdue payables found.');
            return Command::SUCCESS;
        }

        foreach ($overduePayables as $payable) {
            $payable->fine += 10;
            $payable->save();

            $this->info("Fine applied to payable ID: {$payable->id}");
        }

        $this->info('Fines calculation completed.');
        return Command::SUCCESS;
    }
}
