<?php

namespace App\Http\Controllers;

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
        return Payable::where('property_id', $property->id)
            ->when($request->state, function ($query) use ($request) {
                $query->where('state', $request->state);
            })
            ->paginate();
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
}
