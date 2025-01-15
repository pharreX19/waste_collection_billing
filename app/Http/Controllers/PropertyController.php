<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Models\Property;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::paginate();
        return Inertia::render('Properties/Index', $properties);
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
        return Inertia::render('Properties/View', $property);
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


    /**
     * Display a listing of the resource.
     */
    public function search(Request $request)
    {
        $properties = Property::where('name', 'LIKE', $request->name)
            ->orWhere('registration_code', 'LIKE', $request->name)
            ->get();

        return Inertia::render('Properties/Search', $properties);
    }
}
