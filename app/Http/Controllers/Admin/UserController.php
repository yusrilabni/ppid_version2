<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $unitMap = \App\Helpers\GeneralHelper::getUnitData();
        return view('admin.users.index', compact('users', 'unitMap'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = \App\Helpers\GeneralHelper::getEncodedUnitData();
        return view('admin.users.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nip' => 'nullable|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,user,superadmin',
            'unit_id' => 'required_if:role,admin,superadmin|nullable|string',
        ]);

        $unitId = $request->unit_id;
        if ($unitId && str_starts_with($unitId, 'B64_')) {
            $unitId = base64_decode(substr($unitId, 4));
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'unit_id' => $unitId,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $units = \App\Helpers\GeneralHelper::getEncodedUnitData();
        $currentUnitId = $user->unit_id ? 'B64_' . base64_encode($user->unit_id) : null;
        return view('admin.users.edit', compact('user', 'units', 'currentUnitId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'nip' => 'nullable|string|max:20|unique:users,nip,'.$user->id,
            'role' => 'required|string|in:admin,user,superadmin',
            'unit_id' => 'required_if:role,admin,superadmin|nullable|string',
        ]);

        $unitId = $request->unit_id;
        if ($unitId && str_starts_with($unitId, 'B64_')) {
            $unitId = base64_decode(substr($unitId, 4));
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'role' => $request->role,
            'unit_id' => $unitId,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('deleted', 'User deleted successfully.');
    }
}
