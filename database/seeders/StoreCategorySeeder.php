<?php

namespace Database\Seeders;

use App\Models\StoreCategory;
use Illuminate\Database\Seeder;

class StoreCategorySeeder extends Seeder
{
    public function run()
    {
        StoreCategory::create([
            'name' => 'INDUSTRI PENGOLAHAN'
        ]);

        StoreCategory::create([
            'name' => 'PERTANIAN, PETERNAKAN, KEHUTANAN dan PERIKANAN'
        ]);

        StoreCategory::create([
            'name' => 'PEDAGANG ECERAN'
        ]);

        StoreCategory::create([
            'name' => 'TOKO KELONTONG'
        ]);

        StoreCategory::create([
            'name' => 'INDUSTRI PENGOLAHAN MAKANAN'
        ]);

        StoreCategory::create([
            'name' => 'INDUSTRI PENGOLAHAN KERAJINAN KAYU DAN ANYAMAN'
        ]);

        StoreCategory::create([
            'name' => 'BANGUNAN'
        ]);

        StoreCategory::create([
            'name' => 'INDUSTRI PENGOLAHAN MINUMAN'
        ]);

        StoreCategory::create([
            'name' => 'INDUSTRI PENGOLAHAN HANDYCRAFT'
        ]);

        StoreCategory::create([
            'name' => 'JASA BOGA (KATERING)'
        ]);

        StoreCategory::create([
            'name' => 'INDUSTRI PENGOLAHAN NON LOGAM'
        ]);

        StoreCategory::create([
            'name' => 'INDUSTRI PENGOLAHAN LOGAM'
        ]);

        StoreCategory::create([
            'name' => 'PUSAT PENJUALAN MAKANAN (FOOD COURT)'
        ]);

        StoreCategory::create([
            'name' => 'INDUSTRI PENGOLAHAN BATIK'
        ]);

        StoreCategory::create([
            'name' => 'USAHA RESTORAN'
        ]);

        StoreCategory::create([
            'name' => 'KAFE'
        ]);

    }
}
