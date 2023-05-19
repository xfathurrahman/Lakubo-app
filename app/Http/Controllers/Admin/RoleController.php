<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        /*$roles = Role::whereNotIn('name', ['admin'])->get();*/
        $roles = Role::all();
        $permissions = Permission::all();
        $role_permission = Role::with('permissions')->get();

        return view('admin.development.roles.index', compact('roles','permissions','role_permission'));
    }

    public function create()
    {
        /*return view('admin.roles.create');*/
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        Role::create($validated);

        return back()->with('message', 'Role Created successfully.');
    }

    public function edit(Role $role)
    {
        /*$permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));*/
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        $role->update($validated);
        $role->syncPermissions($request->permission);

        return back()->with('success', 'Peran dan Hak akses berhasil di ubah.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Peran di hapus.');
    }

/*    public function givePermission(Request $request, Role $role)
    {
        if($role->hasPermissionTo($request->permission)){
            return back()->with('message', 'Permission exists.');
        }
        $role->givePermissionTo($request->permission);
        return back()->with('message', 'Permission added.');
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if($role->hasPermissionTo($permission)){
            $role->revokePermissionTo($permission);
            return back()->with('message', 'Permission revoked.');
        }
        return back()->with('message', 'Permission not exists.');
    }*/

}
