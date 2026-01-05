<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Jakarta - Bandung
        Schedule::create([
            'transportation_id' => 1, // Primajasa
            'route_id' => 1,
            'date_departure' => '2026-01-06 08:00:00',
            'date_arrival' => '2026-01-06 11:00:00', 
            'price' => 75000
        ]);

        Schedule::create([
            'transportation_id' => 2, // Sinar Jaya
            'route_id' => 1,
            'date_departure' => '2026-01-06 08:00:00',
            'date_arrival' => '2026-01-06 11:30:00',
            'price' => 50000
        ]);

        // Jakarta - Surabaya
        Schedule::create([
            'transportation_id' => 4, // Kereta
            'route_id' => 2,
            'date_departure' => '2026-01-06 19:00:00',
            'date_arrival' => '2026-01-07 07:00:00',
            'price' => 350000
        ]);

        // Travel Jakarta - Bandung
        Schedule::create([
            'transportation_id' => 3, // Cipaganti
            'route_id' => 1,
            'date_departure' => '2026-01-06 09:00:00',
            'date_arrival' => '2026-01-06 12:00:00',
            'price' => 100000
        ]);
    }
}