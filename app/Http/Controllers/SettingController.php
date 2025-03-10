<?php

namespace App\Http\Controllers;

use App\Constants\Role;
use App\Models\PropertyCategory;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = [];

        switch ($request->query('type')) {
            case 'users':
                $data = User::where('role_id', Role::OFFICER)->paginate();
                break;

            case 'categories':
                $data = PropertyCategory::paginate();
                break;

            case 'payables':
                $data = Setting::all();
                break;
        }

        return Inertia::render('Settings/Index', [
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request)
    {
        $data = $request->all();

        foreach ($data as $item) {
            Setting::where('id', $item['id'])->update(['value' => $item['value']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
