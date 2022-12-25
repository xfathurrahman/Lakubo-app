<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'username' => 'admin',
            'name' => 'administrator',
            'email' => 'admin@gmail.com',
            'phone' => '081234567890',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ])->assignRole('seller','admin');

        UserAddress::create([
            'user_id' => $user->id,
            'province_id' => 33,
            'regency_id' => 3309,
            'district_id' => 3309050,
            'village_id' => 3309050004,
            'detail_address' => 'jl. garuda no 12 ( sebelah toko cat )',
        ]);

    }
}
