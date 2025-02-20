<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Inertia\Inertia;
use App\Constants\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
    public function show()
    {
        $user = User::with(['role'])->findOrFail(auth()->user()->id);
        return Inertia::render('Auth/Profile', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $updateFields = [];

        if (auth()->user()->role_id === Role::ADMIN) {
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
        } else {

            $user = auth()->user();

            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['ތިޔަ ޖެއްސެވި ޕާސްވާރޑް ރަނގަޅެއް ނޫން'],
                ]);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
