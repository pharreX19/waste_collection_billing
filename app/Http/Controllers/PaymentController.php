<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Payment::paginate();
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
