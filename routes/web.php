<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminStoreController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StoreCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class,'index']);
Route::get('/detail/product/{id}', [HomeController::class,'getProduct'])->name('getProduct');

Route::get('/indoregion/boyolali', [IndoRegionController::class,'getBoyolali'])->name('getBoyolali');
Route::get('/indoregion/province', [IndoRegionController::class, 'getProvince'])->name('getProvince');
Route::get('/indoregion/regency/{id}', [IndoRegionController::class, 'getRegency'])->name('getRegency');
Route::get('/indoregion/district/{id}', [IndoRegionController::class, 'getDistrict'])->name('getDistrict');
Route::get('/indoregion/village/{id}', [IndoRegionController::class, 'getVillage'])->name('getVillage');
Route::get('/getimage/{id}', [ProductController::class, 'getImage'])->name('getImage');

Route::middleware(['auth', 'verified', 'role:admin'])->name('admin.')->prefix('admin')->group(function (){
    Route::get('/dashboard',[AdminDashboardController::class,'index'])->name('dashboard');
    /*-----------------------------------------------Produk-------------------------------------------------------*/
    Route::get('/products',[AdminProductController::class,'index'])->name('products');
    /*-----------------------------------------------Lapak-------------------------------------------------------*/
    Route::get('/stores',[AdminStoreController::class,'index'])->name('stores');
    /*-----------------------------------------------Kategori-------------------------------------------------------*/
    Route::get('/categories',[CategoryController::class,'index'])->name('categories');
    Route::post('/categories/products/create',[CategoryController::class,'storeCateProd'])->name('product.category.store');
    Route::post('/categories/stores/create',[CategoryController::class,'storeCateStore'])->name('store.category.store');
    Route::put('/categories/products/{id}/edit',[CategoryController::class,'updateCateProd'])->name('product.category.update');
    Route::put('/categories/store/{id}/edit',[CategoryController::class,'updateCateStore'])->name('store.category.update');
    Route::delete('/categories/product/{id}/delete',[CategoryController::class,'deleteCateProd'])->name('product.category.delete');
    Route::delete('/categories/store/{id}/delete',[CategoryController::class,'deleteCateStore'])->name('store.category.delete');
    /*-----------------------------------------------Hak akses & Peran-------------------------------------------------------*/
    Route::get('/manage/roles',[RoleController::class,'index'])->name('roles.index');
    Route::post('/roles/create',[RoleController::class,'store'])->name('roles.store');
    Route::put('/roles/{role}/update',[RoleController::class,'update'])->name('roles.update');
    Route::delete('/roles/{role}/delete',[RoleController::class,'destroy'])->name('roles.delete');
    Route::get('/manage/permissions',[PermissionController::class,'index'])->name('permissions.index');
    Route::post('/permissions/create',[PermissionController::class,'store'])->name('permissions.store');
    Route::put('/permissions/{permission}/update',[PermissionController::class,'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}/delete',[PermissionController::class,'destroy'])->name('permissions.delete');
    /*-----------------------------------------------Pengguna-------------------------------------------------------*/
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
    Route::put('/store/{store}/update',[StoreController::class,'update'])->name('store.update');
    Route::delete('/store',[StoreController::class,'destroy'])->name('store.destroy');
    Route::get('/products', [ProductController::class,'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class,'create'])->name('products.create');
    Route::post('/products/create', [ProductController::class,'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class,'edit'])->name('products.edit');
    Route::put('/products/{product}/update', [ProductController::class,'update'])->name('products.update');
    Route::delete('/products/{product}/delete', [ProductController::class,'destroy'])->name('products.delete');
});

Route::middleware(['auth', 'verified', 'role:customer'])->name('customer.')->prefix('customer')->group(function (){
    Route::post('/store/new', [CustomerController::class,'store'])->name('store.new');
    Route::get('/store/district', [CustomerController::class,'getDistrict'])->name('store.getDistrict');
    Route::get('/store/categories/', [CustomerController::class,'getStoreCate'])->name('store.getStoreCate');
    Route::get('/orders', [OrderController::class,'index'])->name('orders');
    // CART
    Route::get('/cart', [CartController::class,'index'])->name('cart.index');
    Route::post('/add-to-cart',[CartController::class,'addProductToCart'])->name('addToCart');
    Route::get('/load-cart-data',[CartController::class,'cartCount'])->name('cartCount');
    Route::post('/delete-cart-item',[CartController::class,'deleteCartItem'])->name('delete.cartItem');
    Route::put('/update-cart-item',[CartController::class,'updateCartItem'])->name('update.cartItem');
    // CHECKOUT
    Route::get('/checkout/{store_id}', [CheckoutController::class,'index'])->name('checkout.index');
    Route::post('/checkout/{store_id}', [CheckoutController::class,'store'])->name('checkout.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::put('/update-shipping',[CheckoutController::class,'updateShipping'])->name('update.shipping');
    Route::post('/get-snap-token',[CheckoutController::class,'getSnapToken'])->name('snap.token');
    Route::get('/order/detail/{order_id}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/order/detail/{order_id}', [OrderController::class, 'show'])->name('order.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
