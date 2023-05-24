<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('Homepage', function (BreadcrumbTrail $trail) {
    $trail->push('Beranda', route('home'));
});

/*------------------------------------------------------------------------------*/
/*-----------------------------BEGIN: Admin Page--------------------------------*/
/*------------------------------------------------------------------------------*/

Breadcrumbs::for('admin_dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('Homepage'); // Beranda
    $trail->push('Admin Dashboard', route('admin.dashboard')); // Admin Dashboard
});

Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('admin_dashboard'); // Admin Dashboard
    $trail->push('Daftar Pengguna', url('admin/users')); // Daftar Pengguna
});

Breadcrumbs::for('user-edit', function (BreadcrumbTrail $trail) {
    $trail->parent('users'); // Daftar Pengguna
    $trail->push('Edit Pengguna', url('#')); // Pengguna > Edit Pengguna
});

Breadcrumbs::for('admin_products', function (BreadcrumbTrail $trail) {
    $trail->parent('admin_dashboard'); // Admin Dashboard
    $trail->push('Daftar Produk', url('admin/products')); // Daftar Produk
});

Breadcrumbs::for('admin_stores', function (BreadcrumbTrail $trail) {
    $trail->parent('admin_dashboard'); // Admin Dashboard
    $trail->push('Daftar Pelapak', url('admin/stores')); // Daftar Pelapak
});

// Categories
Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->parent('admin_dashboard'); // Admin Dashboard
    $trail->push('Kelola Kategori', url('admin/categories')); // Kelola Kategori
});

// Konfirmasi Orders
Breadcrumbs::for('admin-confirmOrders', function (BreadcrumbTrail $trail) {
    $trail->parent('admin_dashboard'); // Admin Dashboard
    $trail->push('Konfirmasi Order', url('admin/confirm/orders')); // Konfirmasi Orders
});

// Transaksi Pelanggan
Breadcrumbs::for('customer-transactions', function (BreadcrumbTrail $trail) {
    $trail->parent('admin_dashboard'); // Admin Dashboard
    $trail->push('Transaksi Pengguna', url('admin/transactions/customers')); // Transaksi Pelanggan
});

// Transaksi Lapak
Breadcrumbs::for('store-transactions', function (BreadcrumbTrail $trail) {
    $trail->parent('admin_dashboard'); // Admin Dashboard
    $trail->push('Transaksi Lapak', url('admin/transactions/stores')); // Transaksi Lapak
});

// penarikan lapak
Breadcrumbs::for('store-withdrawal', function (BreadcrumbTrail $trail) {
    $trail->parent('admin_dashboard'); // Admin Dashboard
    $trail->push('Penarikan Dana Lapak', url('admin/withdrawal/store')); // Penarikan lapak
});

// penarikan pelaanggan
Breadcrumbs::for('customer-withdrawal', function (BreadcrumbTrail $trail) {
    $trail->parent('admin_dashboard'); // Admin Dashboard
    $trail->push('Penarikan Dana Pengguna', url('admin/withdrawal/customer')); // Penarikan pelaanggan
});


// Kelola Peran
Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->parent('admin_dashboard'); // Admin Dashboard
    $trail->push('Kelola Peran', url('admin/roles')); // Kelola Peran
});

// Kelola Hak Akses
Breadcrumbs::for('permissions', function (BreadcrumbTrail $trail) {
    $trail->parent('admin_dashboard'); // Admin Dashboard
    $trail->push('Kelola Hak Akses', url('admin/permissions')); // Kelola Hak Akses
});

/*------------------------------------------------------------------------------*/
/*-----------------------------BEGIN: Seller Page--------------------------------*/
/*------------------------------------------------------------------------------*/

// Dashboard
Breadcrumbs::for('seller_dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('Homepage'); // Beranda
    $trail->push('Dashboard Lapak', route('seller.dashboard')); // Dashboard Lapak
});

// Store
Breadcrumbs::for('store', function (BreadcrumbTrail $trail) {
    $trail->parent('seller_dashboard');
    $trail->push('UMKM Saya', route('seller.store.index'));
});

// Produk
Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->parent('seller_dashboard');
    $trail->push('Produk', url('seller/products'));
});

// Produk > Tambah Produk
Breadcrumbs::for('product_add', function (BreadcrumbTrail $trail) {
    $trail->parent('seller_dashboard');
    $trail->push('Tambah Produk', url('#'));
});

// Produk > Edit Produk
Breadcrumbs::for('product_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('seller_dashboard');
    $trail->push('Edit Produk', url('#'));
});

// Pesanan
Breadcrumbs::for('orders', function (BreadcrumbTrail $trail) {
    $trail->parent('seller_dashboard');
    $trail->push('Pesanan', url('seller/orders'));
});

Breadcrumbs::for('seller-order-detail', function (BreadcrumbTrail $trail) {
    $trail->parent('orders');
    $trail->push('Detail Pesanan ', url('#')); // Pesanan > detail
});

// Pesanan
Breadcrumbs::for('store-withdrawals', function (BreadcrumbTrail $trail) {
    $trail->parent('seller_dashboard');
    $trail->push('Penarikan dana', url('seller/withdrawals'));
});

/*-------------------------------------------------------------------------------*/
/*-----------------------------BEGIN: Customer Page------------------------------*/
/*-------------------------------------------------------------------------------*/

Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->parent('Homepage');
    $trail->push('Akun Saya', route('profile.edit')); // Profile edit
});

Breadcrumbs::for('my-order', function (BreadcrumbTrail $trail) {
    $trail->parent('profile');
    $trail->push('Pesanan Saya', route('customer.orders')); // Pesanan saya
});

Breadcrumbs::for('my-order-detail', function (BreadcrumbTrail $trail) {
    $trail->parent('my-order');
    $trail->push('Detail Pesanan ', url('#')); // Pesanan saya > detail
});

// Transaksi saya
Breadcrumbs::for('transaction', function (BreadcrumbTrail $trail) {
    $trail->parent('profile');
    $trail->push('Transaksi Saya', route('customer.transaction.index'));
});

// Penarikan Dana
Breadcrumbs::for('withdraw', function (BreadcrumbTrail $trail) {
    $trail->parent('profile');
    $trail->push('Penarikan Dana', route('customer.withdraw.index'));
});


/*END: Customer Page*/

/////////////////////////////////////////////////////////////////////////////////


/*// Home > Blog > [Category]
Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category));
});*/
