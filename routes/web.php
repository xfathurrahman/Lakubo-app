<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\SellerDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth', 'verified', 'role:admin'])->name('admin.')->prefix('admin')->group(function (){
    //Roles
    /*Route::resource('/roles', RoleController::class);*/
    Route::resource('/',AdminDashboardController::class);
    Route::get('/roles',[RoleController::class,'index'])->name('roles.index');
    Route::post('/roles/create',[RoleController::class,'store'])->name('roles.store');
    Route::put('/roles/{role}/update',[RoleController::class,'update'])->name('roles.update');
    Route::delete('/roles/{role}/delete',[RoleController::class,'destroy'])->name('roles.delete');
    //Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    //Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    // Permission
    //Route::resource('/permissions', PermissionController::class);
    Route::get('/permissions',[PermissionController::class,'index'])->name('permissions.index');
    Route::post('/permissions/create',[PermissionController::class,'store'])->name('permissions.store');
    Route::put('/permissions/{permission}/update',[PermissionController::class,'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}/delete',[PermissionController::class,'destroy'])->name('permissions.delete');
    //Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    //Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');
    // Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    // Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    // Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    // Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UserController::class, 'updateUserAccount'])->name('users.account.update');
    Route::put('/users/access/{user}', [UserController::class, 'updateAccess'])->name('users.access.update');
    Route::put('/users/password/{user}', [UserController::class, 'updatePassword'])->name('users.password.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});


Route::middleware(['auth', 'verified', 'role:seller'])->name('seller.')->prefix('seller')->group(function (){
    Route::resource('/',SellerDashboardController::class);
    // Products
    Route::get('/products', [ProductController::class,'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class,'create'])->name('products.create');
    Route::post('/products/create', [ProductController::class,'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class,'edit'])->name('products.edit');
    Route::put('/products/{product}/update', [ProductController::class,'update'])->name('products.update');
    Route::put('/products/{product}/delete', [ProductController::class,'destroy'])->name('products.delete');
});

Route::middleware(['auth', 'verified', 'role:customer'])->name('customer.')->prefix('customer')->group(function (){
    //
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Route::put('/address/update/{id}', [ProfileController::class, 'updateAddress'])->name('address.update');
    Route::get('/profile/province', [ProfileController::class, 'getProvince'])->name('profile.getProvince');
    Route::get('/profile/regency/{id}', [ProfileController::class, 'getRegency'])->name('profile.getRegency');
    Route::get('/profile/district/{id}', [ProfileController::class, 'getDistrict'])->name('profile.getDistrict');
    Route::get('/profile/village/{id}', [ProfileController::class, 'getVillage'])->name('profile.getVillage');
});

require __DIR__.'/auth.php';
