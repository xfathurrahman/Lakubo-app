<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

/*BEGIN: Admin Page*/

// Dashboard
Breadcrumbs::for('admin_dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Admin Dashboard', route('admin.dashboard'));
});

// Pengguna
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->push('Daftar Pengguna', url('admin/users'));
});

// Pengguna > Edit Pengguna
Breadcrumbs::for('user-edit', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Edit Pengguna', url('#'));
});

// Kelola Peran
Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->push('Kelola Peran', url('admin/roles'));
});

// Kelola Hak Akses
Breadcrumbs::for('permissions', function (BreadcrumbTrail $trail) {
    $trail->push('Kelola Hak Akses', url('admin/permissions'));
});

/*END: Admin Page*/

/////////////////////////////////////////////////////////////////////////////////

/*BEGIN: Seller Page*/

// Dashboard
Breadcrumbs::for('seller_dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Seller Dashboard', route('seller.dashboard'));
});

// Store
Breadcrumbs::for('store', function (BreadcrumbTrail $trail) {
    $trail->push('Lapak UMKM Saya', route('seller.store.index'));
});

// Produk
Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->push('Produk', url('seller/products'));
});

// Produk > Tambah Produk
Breadcrumbs::for('product_add', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Tambah Produk', url('#'));
});

// Produk > Edit Produk
Breadcrumbs::for('product_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Edit Produk', url('#'));
});

/*END: Seller Page*/

/////////////////////////////////////////////////////////////////////////////////

/*BEGIN: Customer Page*/

// Dashboard
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->push('Profile', route('profile.edit'));
});

/*END: Customer Page*/


/*// Home > Blog > [Category]
Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category));
});*/
