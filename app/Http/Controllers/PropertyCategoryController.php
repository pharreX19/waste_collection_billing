<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\PropertyCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PropertyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(PropertyCategory::all(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        PropertyCategory::create($request->validated());

        return to_route('settings.index', [
            'type' => 'categories'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, PropertyCategory $category)
    {
        $category->update($request->validated());

        return to_route('settings.index', [
            'type' => 'categories'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
