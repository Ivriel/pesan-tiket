<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::create([
            'booking_code' => 'TKT-001',
            'user_id' => 3, // Budi
            'schedule_id' => 1, // Primajasa Jakarta-Bandung
            'total_amount' => 150000, // 2 tiket x 75k
            'status' => 'success'
        ]);

        Transaction::create([
            'booking_code' => 'TKT-002',
            'user_id' => 4, // Sari
            'schedule_id' => 2, // Sinar Jaya Jakarta-Bandung
            'total_amount' => 50000, // 1 tiket x 50k
            'status' => 'success'
        ]);

        Transaction::create([
            'booking_code' => 'TKT-003',
            'user_id' => 3, // Budi
            'schedule_id' => 4, // Travel Jakarta-Bandung
            'total_amount' => 300000, // 3 tiket x 100k
            'status' => 'pending'
        ]);
    }
}