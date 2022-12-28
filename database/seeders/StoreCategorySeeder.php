<?php

namespace Database\Seeders;

use App\Models\StoreCategory;
use Illuminate\Database\Seeder;

class StoreCategorySeeder extends Seeder
{
    public function run()
    {
        StoreCategory::create([
            'name' => 'Kerajinan',
            'slug' => 'gambar-1',
            'image' => 'gambar-1.jpg'
        ]);

        StoreCategory::create([
            'name' => 'Kerajinan',
            'slug' => 'gambar-1',
            'image' => 'gambar-1.jpg'
        ]);

    }
}
