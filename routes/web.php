<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminStoreController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ConfirmOrderController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\CustomerTransactionController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\CustomerWithdrawalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndoRegionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\StoreTransactionController;
use App\Http\Controllers\Seller\StoreWithdrawalController;
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

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/term-and-conditions', [HomeController::class,'termAndConditions'])->name('TAC');
Route::get('/privacy-policy', [HomeController::class,'privacyPolicy'])->name('PP');

Route::get('/indoregion/boyolali', [IndoRegionController::class,'getBoyolali'])->name('getBoyolali');
Route::get('/indoregion/province', [IndoRegionController::class, 'getProvince'])->name('getProvince');
Route::get('/indoregion/regency/{id}', [IndoRegionController::class, 'getRegency'])->name('getRegency');
Route::get('/indoregion/district/{id}', [IndoRegionController::class, 'getDistrict'])->name('getDistrict');
Route::get('/indoregion/village/{id}', [IndoRegionController::class, 'getVillage'])->name('getVillage');
Route::get('/getimage/{id}', [ProductController::class, 'getImage'])->name('getImage');

Route::get('/search', [HomeController::class, 'searchProduct'])->name('product.search');
Route::get('/search/result', [HomeController::class, 'searchResult'])->name('product.search.result');
Route::get('/details/product/{id}', [HomeController::class,'getProduct'])->name('product.detail');
Route::get('/details/product/{id}', [HomeController::class,'getProduct'])->name('product.detail');
Route::get('/details/new-product', [HomeController::class,'getNewProduct'])->name('product.detail.new');
Route::get('/details/category/{id}', [HomeController::class,'getProductByCategory'])->name('category.detail');
Route::get('/details/store/{id}', [HomeController::class,'getStoreDetail'])->name('store.details');

Route::middleware(['auth', 'verified', 'role:admin'])->name('admin.')->prefix('admin')->group(function (){
    Route::get('/dashboard',[AdminDashboardController::class,'index'])->name('dashboard');
    /*-----------------------------------------------Produk-------------------------------------------------------*/
    Route::get('/products',[AdminProductController::class,'index'])->name('products');
    Route::delete('/products/{product}/delete',[AdminProductController::class,'destroy'])->name('product.delete');
    /*-----------------------------------------------Lapak-------------------------------------------------------*/
    Route::get('/stores',[AdminStoreController::class,'index'])->name('stores');
    Route::delete('/stores/{store}/delete',[AdminStoreController::class,'destroy'])->name('store.delete');
    /*-----------------------------------------------Carousels-------------------------------------------------------*/
    Route::get('/carousels', [CarouselController::class,'index'])->name('carousels.index');
    Route::post('/carousels/store', [CarouselController::class,'store'])->name('carousels.store');
    Route::put('/carousels/update/{id}', [CarouselController::class,'update'])->name('carousels.update');
    Route::delete('/carousels/delete/{id}', [CarouselController::class,'destroy'])->name('carousels.destroy');
    /*-----------------------------------------------Transactions-------------------------------------------------------*/
    Route::get('/transactions/stores', [AdminTransactionController::class,'storeTransactions'])->name('transaction.stores');
    Route::get('/transactions/customers', [AdminTransactionController::class,'customerTransactions'])->name('transaction.customers');
    Route::post('/transactions/stores/update', [AdminTransactionController::class,'storeTransactionUpdate'])->name('store.transaction.update');
    Route::post('/transactions/customers/update', [AdminTransactionController::class,'customerTransactionUpdate'])->name('customer.transaction.update');
    /*-----------------------------------------------Confirm Order-------------------------------------------------------*/
    Route::get('/confirm/orders', [ConfirmOrderController::class,'index'])->name('confirmOrders');
    Route::post('/confirm/order/{order_id}', [ConfirmOrderController::class, 'confirmOrder'])->name('confirm.order');
    /*-----------------------------------------------Withdrawals-------------------------------------------------------*/
    Route::get('/withdrawal/customers', [WithdrawalController::class,'customerIndex'])->name('withdrawal.customer.index');
    Route::get('/withdrawal/stores', [WithdrawalController::class,'storeIndex'])->name('withdrawal.store.index');
    /*-------------------------------------------------Kategori-------------------------------------------------------*/
    Route::get('/categories/products',[CategoryController::class,'getProduct'])->name('categories.products');
    Route::get('/categories/stores',[CategoryController::class,'getStore'])->name('categories.stores');
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
    /*-------------------------------------------------Pengguna-------------------------------------------------------*/
    Route::get('/manage/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/manage/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UserController::class, 'updateUserAccount'])->name('users.account.update');
    Route::put('/users/access/{user}', [UserController::class, 'updateAccess'])->name('users.access.update');
    Route::put('/users/password/{user}', [UserController::class, 'updatePassword'])->name('users.password.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/admin/users/search', [UserController::class, 'search'])->name('users.search');
});

Route::middleware(['auth', 'verified', 'role:seller'])->name('seller.')->prefix('seller')->group(function (){
    Route::get('/dashboard',[SellerDashboardController::class,'index'])->name('dashboard');
    /*-----------------------------------------------MY STORE---------------------------------------------------------*/
    Route::get('/store',[StoreController::class,'index'])->name('store.index');
    Route::put('/store/{store}/update',[StoreController::class,'update'])->name('store.update');
    Route::delete('/store',[StoreController::class,'destroy'])->name('store.destroy');
    Route::post('/store/update-photo', [StoreController::class, 'updatePhoto'])->name('store.update.photo');
    Route::post('/store/destroy-photo', [StoreController::class, 'destroyPhoto'])->name('store.destroy.photo');
    Route::patch('/store/update-bank', [StoreController::class, 'updateBankAccount'])->name('store.update.bank');
    /*-----------------------------------------------PRODUCTS---------------------------------------------------------*/
    Route::get('/products', [ProductController::class,'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class,'create'])->name('products.create');
    Route::post('/products/create', [ProductController::class,'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class,'edit'])->name('products.edit');
    Route::put('/products/{product}/update', [ProductController::class,'update'])->name('products.update');
    Route::delete('/products/{product}/delete', [ProductController::class,'destroy'])->name('products.delete');
    /*-----------------------------------------------ORDERS-----------------------------------------------------------*/
    Route::get('/orders', [SellerOrderController::class,'index'])->name('orders.index');
    Route::get('/orders/detail/{order_id}', [SellerOrderController::class,'show'])->name('order.show');
    Route::put('/orders/detail/status/{order_id}', [SellerOrderController::class,'updateStatus'])->name('order.update.status');
    Route::put('/orders/detail/confirm/{order_id}', [SellerOrderController::class,'confirmOrder'])->name('order.confirm');
    Route::put('/orders/detail/reject/{order_id}', [SellerOrderController::class,'rejectOrder'])->name('order.reject');
    Route::put('/orders/detail/resi/{order_id}', [SellerOrderController::class,'updateResi'])->name('order.update.resi');
    /*-----------------------------------------------WITHDRAW---------------------------------------------------------*/
    Route::get('/withdrawals', [StoreWithdrawalController::class, 'index'])->name('withdraw.index');
    Route::post('/withdraw/store', [StoreWithdrawalController::class, 'store'])->name('withdraw.store');
    /*-----------------------------------------------TRANSACTIONS-----------------------------------------------------*/
    Route::get('/transaction', [StoreTransactionController::class, 'index'])->name('transaction.index');
});

Route::middleware(['auth', 'verified', 'role:customer'])->name('customer.')->prefix('customer')->group(function (){
    Route::post('/store/new', [CustomerController::class,'store'])->name('store.new');
    Route::get('/store/district', [CustomerController::class,'getDistrict'])->name('store.getDistrict');
    Route::get('/store/categories/', [CustomerController::class,'getStoreCate'])->name('store.getStoreCate');
    Route::get('/orders', [OrderController::class,'index'])->name('orders');
    /*-----------------------------------------------CARTS------------------------------------------------------------*/
    Route::get('/cart', [CartController::class,'index'])->name('cart.index');
    Route::post('/add-to-cart',[CartController::class,'addProductToCart'])->name('addToCart');
    Route::get('/load-cart-data',[CartController::class,'cartCount'])->name('cartCount');
    Route::post('/delete-cart-item',[CartController::class,'deleteCartItem'])->name('delete.cartItem');
    Route::put('/update-cart-item',[CartController::class,'updateCartItem'])->name('update.cartItem');
    /*-----------------------------------------------CHECK OUT--------------------------------------------------------*/
    Route::get('/checkout/{cart_id}', [CheckoutController::class,'index'])->name('checkout.index');
    Route::post('/checkout/{cart_id}', [CheckoutController::class,'store'])->name('checkout.store');
    Route::post('/get-shipping-data', [CheckoutController::class,'getShippingCost'])->name('shipping.cost');
    /*-----------------------------------------------ORDERS-----------------------------------------------------------*/
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/order/detail/{order_id}', [OrderController::class, 'show'])->name('order.show');
    Route::put('/order/detail/{order_id}', [OrderController::class, 'update'])->name('order.update');
    Route::put('/order/detail/confirm/{order_id}', [OrderController::class, 'confirmOrder'])->name('order.confirm');
    /*-----------------------------------------------WITHDRAW---------------------------------------------------------*/
    Route::get('/withdraw', [CustomerWithdrawalController::class, 'index'])->name('withdraw.index');
    Route::post('/withdraw/store', [CustomerWithdrawalController::class, 'store'])->name('withdraw.store');
    /*-----------------------------------------------TRANSACTIONS-----------------------------------------------------*/
    Route::get('/transaction', [CustomerTransactionController::class, 'index'])->name('transaction.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
    Route::get('/profile/get-session-message', [ProfileController::class, 'getSessionMessage']);
    Route::post('/profile/destroy-photo', [ProfileController::class, 'destroyPhoto'])->name('profile.destroy.photo');
    Route::patch('/profile/update-bank', [ProfileController::class, 'updateBankAccount'])->name('profile.update.bank');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
