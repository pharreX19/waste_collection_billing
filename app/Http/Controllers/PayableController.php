<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Constants\Role;
use App\Models\Payable;
use App\Models\Property;
// use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use App\Services\GenerateReport;
use App\Services\GenerateReports;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Services\FormatDhivehiDate;
use Spatie\Browsershot\Browsershot;
use App\Http\Requests\PayableRequest;
use Illuminate\Support\Facades\Response;
use App\Libraries\Traits\PropertyAccessGuard;
use App\Constants\Payable as ConstantsPayable;

class PayableController extends Controller
{
    use PropertyAccessGuard;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Property $property)
    {
        $state = (isset($request->state) ? [$request->state]  : $request->state === ConstantsPayable::PENDING) ? ConstantsPayable::PENDING_STATES : [];

        $this->ensureUserIsResponsible($property);

        $total_pending = DB::table('payables')
            ->select('state')
            ->selectRaw('SUM(balance) as total_balance')
            ->where('property_id', $property->id)
            ->whereIn('state', ConstantsPayable::PENDING_STATES)
            ->groupBy('state')
            ->get();

        $property->load(['responsiblePersons', 'category', 'payables' => function ($query) use ($request, $state) {
            $query->when(count($state) > 0, function ($q) use ($state) {
                $q->whereIn('state', $state);
            });

            $query->when($request->year, function ($q) use ($request) {
                $q->whereYear('billed_period', $request->year)
                    ->with('payments')
                    ->orderBy('billed_period', 'desc');
            });
        }]);

        if ($request->isJson() /*&& auth()->user()->role_id != Role::USER*/) {
            return response()->json([
                'property' => $property
            ]);
        }

        $property->setAttribute('total_pending', $total_pending);

        Inertia::share('property_id', $property->id);

        return Inertia::render('Properties/View', $property);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Payable $request)
    // {
    //
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $propertyId, Payable $payable)
    {
        return $payable->load('payments');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PayableRequest $request, Payable $payable)
    {
        $payable->viya_reference_no = $request->viya_reference_no;
        $payable->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Payable $payable)
    // {
    //
    // }

    /**
     * Generate payment reporing.
     */
    public function reports(Request $request)
    {
        $start_date = $request->query('start_date') ?? Carbon::now()->startOfYear()->toDateString();
        $end_date = $request->query('end_date') ?? Carbon::parse($request->query('start_date'))->addYear(1)->toDateString();
        $name = $request->query('name') ?? null;

        $payables = Payable::with('property')
            ->whereDate('billed_period', '>=', $start_date)
            ->whereDate('billed_period', '<', $end_date)
            ->when(isset($name), function ($query) use ($name) {
                $query->whereHas('property', function ($q) use ($name) {
                    $q->where('name', $name);
                });
            })
            ->paginate();

        $payables->appends([
            'start_date' => $start_date,
            'end_date' => $request->query('end_date'),
        ]);

        return Inertia::render('Payable/Reports', $payables);
    }


    public function downloadReport(Request $request)
    {
        return (new GenerateReports())->handle($request);
    }


    public function print(Payable $payable)
    {
        $payable->load('property', 'payments');
        return Inertia::render('Payment/Print', [
            'payable' => $payable
        ]);
    }
}
