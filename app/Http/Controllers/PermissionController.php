<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
     public static function middleware(): array
    {
        return [
            new Middleware('permission:view permissions', only: ['index', 'show']),
            new Middleware('permission:create permissions', only: ['create', 'store']),
            new Middleware('permission:edit permissions', only: ['edit', 'update']),
            new Middleware('permission:delete permissions', only: ['destroy']),
        ];
    }

    public function index()
    {
        $permission = Permission::orderBy('created_at', 'desc')->paginate(10);
        return view('permissions.index', [
            'permissions' => $permission,
        ]);
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        // Validate and create permission
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

            Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
        $permission = Permission::findById($id);
        return view('permissions.edit', [
            'permission' => $permission,
        ]);
    }

    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$id,
        ]); 
        $permission = Permission::findById($id);
        $permission->name = $request->name;
        $permission->save();
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $permission = Permission::findById($id);
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }

}
