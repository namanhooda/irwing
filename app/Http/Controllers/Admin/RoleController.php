<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all(); 
        return view('admin.roles.index', compact('roles', 'permissions'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array', // optional but good practice
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web', // ensure it matches your permissions
        ]);

        // Assign permissions if selected
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->back()->with('success', 'Role created successfully.');
    }
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        // Get permission names by IDs
        $permissions = Permission::whereIn('id', $request->permissions ?? [])->pluck('name')->toArray();

        // Sync permissions
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }


public function switchRole(Request $request)
{
    $request->validate([
        'role' => 'required|string',
    ]);

    $user = auth()->user();
    $role = $request->role;

if ($user->hasRole($role)) {
    session()->put('active_role', $role);
    session()->save(); // Ensures it's stored before redirecting

    return redirect()->route('dashboard')->with('success', 'Switched to role: ' . $role);
}

return redirect()->route('dashboard')->with('error', 'You do not have this role.');
}





}
