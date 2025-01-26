<?php

namespace App\Http\Controllers;

use App\Actions\Person\PersonCreateAction;
use App\Actions\Property\PropertyCreateAction;
use App\Http\Requests\PropertyRequest;
use App\Models\Person;
use App\Models\PersonProperty;
use App\Models\Property;
use App\Services\PropertyAndResponsiblePeopleCreateService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Symfony\Component\Uid\Ulid;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $properties = [];

        if ($request->query('query')) {
            $properties = Property::where('name', 'like', '%' . $request->query('query') . '%')->get();
            return response()->json($properties);
        } else {
            $properties = Property::with(['responsiblePersons', 'category'])->latest('id')->paginate();
            return Inertia::render('Properties/Index', $properties);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        (new PropertyAndResponsiblePeopleCreateService())->execute($request->all());

        // $owner = (new PersonCreateAction())->execute($request->all());

        // $property_data = [
        //     ...$request->all(),
        //     $owner
        // ];
        // $property = (new PropertyCreateAction())->execute($property_data);

        // foreach ($request->all()['responsible_persons'] as $person) {
        //     $responsible_person = (new PersonCreateAction())->execute($person);

        //     PersonProperty::create([
        //         'id' => Ulid::generate(),
        //         'responsible_person_id' => $responsible_person->id,
        //         'property_id' => $property->id,
        //     ]);
        // }

        return to_route('properties.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property, Request $request)
    {
        $property->load(['responsiblePersons', 'category', 'payables']);
        //  => function ($query) use ($request) {
        // $query->whereYear('billed_period', $request->year)
        // ->with('payments');
        // }]);

        return response()->json($property, Response::HTTP_OK);
        // return Inertia::render('Properties/View', $property);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        (new PropertyAndResponsiblePeopleCreateService())->execute($request->all());
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

        return response()->json($properties);
    }
}
