<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'add-to-cart'])->assignRole('customer');
        Permission::create(['name' => 'edit-category'])->assignRole('admin');
        Permission::create(['name' => 'edit-product'])->assignRole('seller');
        Permission::create(['name' => 'update-bank-account'])->assignRole('customer');
        Permission::create(['name' => 'show-cart'])->assignRole('customer');
        Permission::create(['name' => 'delete-account']);
    }
}
