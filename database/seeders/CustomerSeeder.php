<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ])->assignRole('customer');

        User::create([
            'name' => 'customer2',
            'email' => 'customer2@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ])->assignRole('customer');

        User::create([
            'name' => 'customer3',
            'email' => 'customer3@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ])->assignRole('customer');

        User::create([
            'name' => 'customer4',
            'email' => 'customer4@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ])->assignRole('customer');

        User::create([
            'name' => 'customer5',
            'email' => 'customer5@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ])->assignRole('customer');
    }
}
