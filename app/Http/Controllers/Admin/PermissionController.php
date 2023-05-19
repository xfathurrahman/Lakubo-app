<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $role_permission = Permission::with('roles')->get();

        return view('admin.development.permissions.index', compact('roles','permissions','role_permission'));
    }

    public function create()
    {
        //return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all() ,[
            'name'   =>  'required|min:3|unique:'.Permission::class,
        ]);

        if($validation->fails()) {
            return back()->with('error', "Hak akses '$request->name' sudah ada.");
        }

        Permission::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Hak akses berhasil di buat.');
    }

    public function edit(Permission $permission)
    {
        //$roles = Role::all();
        //return view('admin.permissions.edit', compact('permission', 'roles'));
    }

    public function update(Request $request, Permission $permission)
    {
        // hapus semua role yang dimiliki permission
        $permission->syncRoles($request->role);
        $permission->assignRole($request->role);

        if ($permission->hasAnyPermission($request->name)) {
            return back()->with('error', "Hak akses '$request->name' sudah ada.");
        }

        $validated = $request->validate(['name' => ['required', 'min:3']]);
        $permission->update($validated);

        return back()->with('success', 'Peran atau Hak akses berhasil di ubah.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('success', 'Hak akses di hapus.');
    }

    public function assignRole(Request $request, Permission $permission)
    {
        /*if ($permission->hasRole($request->role)) {
            return back()->with('message', 'Role exists.');
        }

        $permission->assignRole($request->role);
        return back()->with('message', 'Role assigned.');*/
    }

    public function removeRole(Permission $permission, Role $role)
    {
        /*if ($permission->hasRole($role)) {
            $permission->removeRole($role);
            return back()->with('message', 'Role removed.');
        }

        return back()->with('message', 'Role not exists.');*/
    }
}
