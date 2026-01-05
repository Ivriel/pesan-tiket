<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        Type::create([
            'name' => 'Bus',
            'description' => 'Transportasi darat dengan kapasitas besar'
        ]);

        Type::create([
            'name' => 'Travel',
            'description' => 'Transportasi darat dengan kapasitas kecil dan nyaman'
        ]);

        Type::create([
            'name' => 'Kereta Api',
            'description' => 'Transportasi darat dengan rel khusus'
        ]);
    }
}