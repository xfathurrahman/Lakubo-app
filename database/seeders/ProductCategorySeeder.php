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
    }
}
