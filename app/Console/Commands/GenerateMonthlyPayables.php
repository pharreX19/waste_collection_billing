<?php

namespace App\Console\Commands;

use App\Constants\Payable as ConstantsPayable;
use Illuminate\Console\Command;
use App\Models\Household;
use App\Models\Payable;
use App\Models\Category;
use App\Models\Property;
use App\Services\ReferenceNoGeneratorService;
use Carbon\Carbon;

class GenerateMonthlyPayables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payables:generate {date? : Start of the month}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly payables for every property';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::parse($this->argument('date')) ?? Carbon::now();
        $currentMonth = $date->startOfMonth();
        $dueDate = $currentMonth->copy()->addDays(40);
        $households = Property::with('category')->where('is_active', 1)->get();

        $payablesCreated = 0;

        foreach ($households as $household) {
            $existingPayable = Payable::where('property_id', $household->id)
                ->where('billed_period', $currentMonth)
                ->first();

            if (!$existingPayable) {
                Payable::create([
                    'property_id' => $household->id,
                    'property_category_id' => $household->property_category_id,
                    'billed_period' => $currentMonth,
                    'reference_no' => (new ReferenceNoGeneratorService())->generate(),
                    'due_date' => $dueDate,
                    'amount' => $household->category->service_fee,
                    'grand_total' => $household->category->service_fee,
                    'balance' => $household->category->service_fee,
                    'fine' => 0.00,
                    'status' => ConstantsPayable::PENDING,
                ]);

                $payablesCreated++;
            }
        }

        $this->info("$payablesCreated payables created for the month of " . $currentMonth->format('F Y'));
        return 0;
    }
}
