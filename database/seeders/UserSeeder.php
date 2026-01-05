<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@pesantiket.com',
            'phone' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Petugas Loket',
            'email' => 'petugas@pesantiket.com', 
            'phone' => '081234567891',
            'role' => 'petugas',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'phone' => '081234567892',
            'role' => 'pelanggan',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Sari Dewi',
            'email' => 'sari@gmail.com',
            'phone' => '081234567893', 
            'role' => 'pelanggan',
            'password' => Hash::make('password123'),
        ]);
    }
}