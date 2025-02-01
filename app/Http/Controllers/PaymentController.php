<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;
use App\Models\Payable;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Symfony\Component\Uid\Ulid;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Property $property, Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        collect($request->validated())->map(function ($item) {
            Payment::create([
                ...$item,
                'payment_date' => now(),
                'state' => 'confirmed'
            ]);
        });

        return response()->json('Payments created success', Response::HTTP_CREATED);
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
