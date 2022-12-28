<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\IndoRegionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\StoreController;
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

Route::get('/indoregion/boyolali', [IndoRegionController::class,'getBoyolali'])->name('getBoyolali');
Route::get('/indoregion/province', [IndoRegionController::class, 'getProvince'])->name('getProvince');
Route::get('/indoregion/regency/{id}', [IndoRegionController::class, 'getRegency'])->name('getRegency');
Route::get('/indoregion/district/{id}', [IndoRegionController::class, 'getDistrict'])->name('getDistrict');
Route::get('/indoregion/village/{id}', [IndoRegionController::class, 'getVillage'])->name('getVillage');


Route::middleware(['auth', 'verified', 'role:admin'])->name('admin.')->prefix('admin')->group(function (){
    Route::get('/dashboard',[AdminDashboardController::class,'index'])->name('dashboard');
    Route::get('/manage/roles',[RoleController::class,'index'])->name('roles.index');
    Route::post('/roles/create',[RoleController::class,'store'])->name('roles.store');
    Route::put('/roles/{role}/update',[RoleController::class,'update'])->name('roles.update');
    Route::delete('/roles/{role}/delete',[RoleController::class,'destroy'])->name('roles.delete');
    Route::get('/manage/permissions',[PermissionController::class,'index'])->name('permissions.index');
    Route::post('/permissions/create',[PermissionController::class,'store'])->name('permissions.store');
    Route::put('/permissions/{permission}/update',[PermissionController::class,'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}/delete',[PermissionController::class,'destroy'])->name('permissions.delete');
    Route::get('/manage/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/manage/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UserController::class, 'updateUserAccount'])->name('users.account.update');
    Route::put('/users/access/{user}', [UserController::class, 'updateAccess'])->name('users.access.update');
    Route::put('/users/password/{user}', [UserController::class, 'updatePassword'])->name('users.password.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});


Route::middleware(['auth', 'verified', 'role:seller'])->name('seller.')->prefix('seller')->group(function (){
    Route::get('/dashboard',[SellerDashboardController::class,'index'])->name('dashboard');
    Route::get('/store',[StoreController::class,'index'])->name('store.index');
    Route::get('/products', [ProductController::class,'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class,'create'])->name('products.create');
    Route::post('/products/create', [ProductController::class,'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class,'edit'])->name('products.edit');
    Route::put('/products/{product}/update', [ProductController::class,'update'])->name('products.update');
    Route::put('/products/{product}/delete', [ProductController::class,'destroy'])->name('products.delete');
});

Route::middleware(['auth', 'verified', 'role:customer'])->name('customer.')->prefix('customer')->group(function (){
    Route::post('/store/new', [CustomerController::class,'store'])->name('store.new');
    Route::get('/store/district', [CustomerController::class,'getDistrict'])->name('store.getDistrict');
    Route::get('/store/village/{id}', [CustomerController::class,'getVillage'])->name('store.getVillage');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
