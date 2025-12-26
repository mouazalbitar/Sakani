<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::create([
            'tenant_id' => 1,
            'apartment_id' => 1,
            'start_date' => '2024-07-01',
            'end_date' => '2024-07-10',
            'status' => 'approved',
        ]);
    }
}
