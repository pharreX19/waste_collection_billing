<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Property::paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyRequest $request)
    {
        return Property::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return $property;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyRequest $request, Property $property)
    {
        $property->fill($request->validated());
        return $property->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        return $property->deleteOrFail();
    }
}
