<?php

namespace App\Http\Controllers;

use App\Constants\Role;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Payable;
use App\Models\Property;
use Illuminate\Http\Request;

class PayableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Property $property)
    {
        $overdue_amount = Payable::where('property_id', $property->id)
            ->where('due_date', '<', Carbon::now()->toDateString())
            ->where('state', 'pending')->sum('amount');

        $property->load(['responsiblePersons', 'category', 'payables' => function ($query) use ($request) {
            $query->when($request->state, function ($q) use ($request) {

                $q->where('state', $request->state);
            });

            $query->when($request->year, function ($q) use ($request) {
                $q->whereYear('billed_period', $request->year)
                    ->with('payments');
            });
        }]);

        if ($request->isJson() && auth()->user()->role_id == Role::OFFICER) {
            return response()->json([
                'property' => $property
            ]);
        }

        $property->setAttribute('overdue_amount', $overdue_amount);

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
    // public function update(Request $request, Payable $payable)
    // {
    //
    // }

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


    public function print(Payable $payable)
    {
        $payable->load('property', 'payments');
        return Inertia::render('Payment/Print', [
            'payable' => $payable
        ]);
    }
}
