<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.users.index', compact('users', 'roles', 'permissions'));
    }

    public function show(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    /*public function updateAccountSetting(Request $request, User $user)
    {
        $user->syncRoles($request->role);
        $user->syncPermissions($request->permission);

        $updateUserAccount =  User::find($user->id);
        $updateUserAccount -> name = $request -> new_fullname;
        $updateUserAccount -> email = $request -> new_mail;
        $updateUserAccount -> password =  Hash::make($request->new_pass);
        $updateUserAccount -> update();

        return back()->with('message', 'Pengaturan Akun berhasi di ubah.');
    }*/

    public function updateUserAccount(Request $request, User $user)
    {
        $updateUserAccount =  User::find($user->id);
        $updateUserAccount -> username = $request -> new_username;
        $updateUserAccount -> name = $request -> new_fullname;
        $updateUserAccount -> email = $request -> new_mail;
        $updateUserAccount -> phone = $request -> new_phone;
        $updateUserAccount -> update();
        return back()->with('message', 'Info akun berhasil di ubah.');
    }

    public function updateAccess(Request $request, User $user)
    {
        $user->syncRoles($request->role);
        $user->syncPermissions($request->permission);
        return back()->with('message', 'Peran dan Hak akses berhasil di ubah.');
    }

    public function updatePassword(Request $request, User $user)
    {
        $updateUserPassword =  User::find($user->id);
        $updateUserPassword -> password =  Hash::make($request->new_pass);
        $updateUserPassword -> update();

        return back()->with('message', 'Kata sandi berhasil di ubah.');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('error', 'anda adalah "admin".');
        }
        $user->delete();

        return back()->with('success', "pengguna '$user->name' dihapus.");
    }
}
