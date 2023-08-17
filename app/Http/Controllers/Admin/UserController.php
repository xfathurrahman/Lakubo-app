<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
        $updateUserAccount =  User::query()->find($user->id);
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
        $user -> password =  Hash::make($request->new_pass);
        $user -> update();

        return back()->with('message', 'Kata sandi berhasil di ubah.');
    }

    public function updatePhoto(Request $request, User $user)
    {
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }
        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $name = time().'.'.$image->getClientOriginalExtension();
            $directory = public_path('/storage/profile-photos');
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }
            $path = $directory.'/'.$name;
            Image::make($image->getRealPath())->resize(350, 350)->save($path);
            if ($user->image_path) {
                Storage::delete('public/storage/profile-photos/'.$user->profile_photo_path);
            }
            $user->profile_photo_path = $name;
            $user->update();
            return response()->json(['message' => 'Success to update profile photo']);
        }
        return response()->json(['message' => 'Failed to update profile photo']);
    }

    public function destroyPhoto(User $user)
    {
        if ($user->profile_photo_path)
        {
            $path = public_path('storage/profile-photos/'.$user->profile_photo_path);
            if (file_exists($path)) {
                unlink($path);
            }
            $user -> profile_photo_path = null;
            $user -> save();
            return response()->json(['message' => 'Success to delete profile photo']);
        }
        return response()->json(['message' => 'Photo already Empty']);
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('error', 'anda adalah "admin".');
        }

        $hasOrders = Order::query()->where('user_id', $user->id)->exists();
        $hasStoreAndThatStoreHasOrder = Store::query()->where('user_id', $user->id)->whereHas('orders')->exists();

        if ($hasOrders || $hasStoreAndThatStoreHasOrder) {
            return back()->with('error', 'Pengguna sedang dalam transaksi.');
        }

        $user->delete();
        return back()->with('success', "pengguna '$user->name' dihapus.");
    }

    #function for search user
    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->get();
        return view('admin.users.partials.user_list', ['users' => $users]);
    }

}
