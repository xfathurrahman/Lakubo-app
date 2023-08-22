<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        ProductCategory::create([
            'name' => 'Kerajinan'
        ]);

        ProductCategory::create([
            'name' => 'Pertanian'
        ]);

        ProductCategory::create([
            'name' => 'Peternakan'
        ]);

        ProductCategory::create([
            'name' => 'Olahraga'
        ]);

        ProductCategory::create([
            'name' => 'Kesehatan'
        ]);

        ProductCategory::create([
            'name' => 'Aksesoris'
        ]);

        ProductCategory::create([
            'name' => 'Buah & Sayur'
        ]);

        ProductCategory::create([
            'name' => 'Makanan'
        ]);

        ProductCategory::create([
            'name' => 'Minuman'
        ]);

        ProductCategory::create([
            'name' => 'Olahraga'
        ]);
    }
}
