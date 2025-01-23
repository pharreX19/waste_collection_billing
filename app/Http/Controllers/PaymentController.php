<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;
use App\Models\Payable;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Property $property, Request $request)
    {
        $overdue_amount = Payable::where('property_id', $property->id)->where('state', 'pending')->sum('amount');

        $property->load(['responsiblePersons', 'category', 'payables' => function ($query) use ($request) {
            $query->whereYear('billed_period', $request->year)
                ->with('payments');
        }]);

        $property->setAttribute('overdue_amount', $overdue_amount);

        return Inertia::render('Properties/View', $property);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        return Payment::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return $payment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $payment->fill([
            'state' => $request->state
        ]);

        return $payment->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Payment $payment)
    {
        $payment->fill([
            'state' => $request->state
        ]);

        return $payment->save();
    }
}
