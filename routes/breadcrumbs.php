<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
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


/*// Home > Blog > [Category]
Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category));
});*/
