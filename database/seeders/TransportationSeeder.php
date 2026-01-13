<?php

namespace Database\Seeders;

use App\Models\Transportation;
use Illuminate\Database\Seeder;

class TransportationSeeder extends Seeder
{
    public function run(): void
    {
        // Bus
        Transportation::create([
            'name' => 'Primajasa Executive',
            'code' => 'PJ-001',
            'total_seat' => 40,
        ]);

        Transportation::create([
            'name' => 'Sinar Jaya Ekonomi',
            'code' => 'SJ-045',
            'total_seat' => 45,
        ]);

        // Travel
        Transportation::create([
            'name' => 'Cipaganti Travel',
            'code' => 'CP-12',
            'total_seat' => 12,
        ]);

        // Kereta
        Transportation::create([
            'name' => 'Argo Bromo Anggrek',
            'code' => 'KA-ABA',
            'total_seat' => 200,
        ]);
    }
}
