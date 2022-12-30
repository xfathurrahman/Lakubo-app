<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        ProductCategory::create([
            'name' => 'VAS bunga',
            'image_path' => 'gambar-1.jpg'
        ]);
    }
}
