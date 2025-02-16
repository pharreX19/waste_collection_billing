<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        User::create($request->validated());
        return to_route('settings.index', [
            'type' => 'users'
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
    public function update(UserRequest $request, User $user)
    {
        $updateFields = [];

        if ($request->filled('is_active')) {
            $updateFields['is_active'] = intval($request->is_active);
        }

        if ($request->filled('password')) {
            $updateFields['password'] = Hash::make($request->password);
        }

        if (!empty($updateFields)) {
            $user->update($updateFields);
        }

        return to_route('settings.index', [
            'type' => 'users'
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
