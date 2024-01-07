<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('pages.backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('pages.backend.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateUser($request);

        $user = new User();
        $user->fill($request->only(['name', 'email', 'status']) + [
            'password' => Hash::make($request->password),
        ]);

        if ($request->hasFile('photo')) {
            $this->uploadPhoto($request, $user, 'user_photos');
        }

        $user = new User;

        $user->assignRole($request->role);

        return redirect()->route('backend.users.index')->with('success', 'User created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('pages.backend.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->validateUser($request, $user->id);

        $user->update($request->only(['name', 'email', 'status']) + [
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        if ($request->hasFile('photo')) {
            $this->deletePhoto($user, 'user_photos');
            $this->uploadPhoto($request, $user, 'user_photos');
        }

        $user->syncRoles($request->role);

        return redirect()->route('backend.users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->deletePhoto($user, 'user_photos');
        $user->delete();
        return redirect()->route('backenduser.index')->with('success', 'User deleted successfully');
    }

    private function validateUser(Request $request, $userId = null)
    {
        $rules = [
            'name' => 'string|required|max:30',
            'email' => 'string|required|unique:users,email,' . $userId,
            'password' => $userId ? 'nullable|string' : 'string|required',
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|mimes:jpg,jpeg,png',
        ];

        $request->validate($rules);
    }
}
