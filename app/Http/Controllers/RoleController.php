<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    //
     public static function middleware(): array
    {
        return [
            new Middleware('permission:view roles', only: ['index', 'show']),
            new Middleware('permission:create roles', only: ['create', 'store']),
            new Middleware('permission:edit roles', only: ['edit', 'update']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }

    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->paginate(10);
        return view('roles.index', [
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        //
       $permissions = Permission::orderBy('name')->get();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        // Validate and create permission
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Role::create(['name' => $request->name]);


        $role = Role::where('name', $request->name)->first();

        $permissions = $request->permissions ?? [];

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::findById($id);
        $permissions = Permission::orderBy('name')->get();
        return view('roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$id,
        ]); 
        $role = Role::findById($id);
        $role->name = $request->name;

        $permissions = $request->permissions;
        $role->syncPermissions($permissions);
    

        $role->save();
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findById($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

}

