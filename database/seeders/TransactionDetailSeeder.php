<?php

namespace Database\Seeders;

use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;

class TransactionDetailSeeder extends Seeder
{
    public function run(): void
    {
        // Transaction 1 - Budi (2 penumpang)
        TransactionDetail::create([
            'transaction_id' => 1,
            'passenger_name' => 'Budi Santoso',
            'passenger_phone' => '081234567892',
            'seat_number' => 1
        ]);

        TransactionDetail::create([
            'transaction_id' => 1,
            'passenger_name' => 'Ani Santoso',
            'passenger_phone' => '081234567894',
            'seat_number' => 2
        ]);

        // Transaction 2 - Sari (1 penumpang)
        TransactionDetail::create([
            'transaction_id' => 2,
            'passenger_name' => 'Sari Dewi',
            'passenger_phone' => '081234567893',
            'seat_number' => 5
        ]);

        // Transaction 3 - Budi family trip (3 penumpang)
        TransactionDetail::create([
            'transaction_id' => 3,
            'passenger_name' => 'Budi Santoso',
            'passenger_phone' => '081234567892',
            'seat_number' => 1
        ]);

        TransactionDetail::create([
            'transaction_id' => 3,
            'passenger_name' => 'Ani Santoso', 
            'passenger_phone' => '081234567894',
            'seat_number' => 2
        ]);

        TransactionDetail::create([
            'transaction_id' => 3,
            'passenger_name' => 'Dika Santoso',
            'passenger_phone' => '081234567895',
            'seat_number' => 3
        ]);
    }
}