<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    //
     public static function middleware(): array
    {
        return [
            new Middleware('permission:view users', only: ['index', 'show']),
            new Middleware('permission:create users', only: ['create', 'store']),
            new Middleware('permission:edit users', only: ['edit', 'update']),
            new Middleware('permission:delete users', only: ['destroy']),
        ];
    }
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }

    // public function show($id)
    // {
    //     $user = User::findOrFail($id);
    //     return view('users.show', compact('user'));
    // }

    //  public function create()
    // {
    //     return view('users.create');
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     $user = User::create([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'password' => bcrypt($validated['password']),
    //     ]);

    //     return redirect()->route('users.index')->with('success', 'User created successfully.');
    // }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name')->get();
    
        $hasRole = $user->roles->pluck('name')->toArray();
        return view('users.edit', compact('user', 'roles', 'hasRole'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
        ]);
        $user->syncRoles($request->roles ?? []);
        $role = Role::findByName($user->roles->first()->name);
        $user->syncPermissions($role->permissions ?? []);
        $user->save();
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

}
