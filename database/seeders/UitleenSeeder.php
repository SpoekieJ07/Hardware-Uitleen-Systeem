<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Uitleen;

class UitleenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Uitleen::create([
            'hardware_id' => 1,
            'user_id' => 1,
            'quantity' => 2,
            'lent_at' => now(),
            'returned_at' => null,
        ]);
    }
}
