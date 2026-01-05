<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        Route::create([
            'departure' => 'Jakarta',
            'arrival' => 'Bandung'
        ]);

        Route::create([
            'departure' => 'Jakarta', 
            'arrival' => 'Surabaya'
        ]);

        Route::create([
            'departure' => 'Bandung',
            'arrival' => 'Yogyakarta'
        ]);

        Route::create([
            'departure' => 'Jakarta',
            'arrival' => 'Semarang'
        ]);
    }
}