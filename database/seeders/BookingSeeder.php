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
            'tenant_id' => 3,
            'apartment_id' => 1,
            'start_date' => '2026-01-01',
            'end_date' => '2026-01-05',
            'status' => 'approved',
        ]);
        Booking::create([
            'tenant_id' => 3,
            'apartment_id' => 3,
            'start_date' => '2026-02-01',
            'end_date' => '2026-02-05',
            'status' => 'approved',
        ]);
        Booking::create([
            'tenant_id' => 3,
            'apartment_id' => 4,
            'start_date' => '2026-03-10',
            'end_date' => '2026-03-15',
            'status' => 'approved',
        ]);
        Booking::create([
            'tenant_id' => 4,
            'apartment_id' => 2,
            'start_date' => '2026-01-10',
            'end_date' => '2026-01-13',
            'status' => 'approved',
        ]);
        Booking::create([
            'tenant_id' => 4,
            'apartment_id' => 4,
            'start_date' => '2026-04-10',
            'end_date' => '2026-04-20',
            'status' => 'approved',
        ]);
        Booking::create([
            'tenant_id' => 4,
            'apartment_id' => 8,
            'start_date' => '2026-01-20',
            'end_date' => '2026-01-23',
            'status' => 'approved',
        ]);
        Booking::create([
            'tenant_id' => 5,
            'apartment_id' => 11,
            'start_date' => '2025-01-25',
            'end_date' => '2025-01-28',
            'status' => 'approved',
        ]);
        Booking::create([
            'tenant_id' => 6,
            'apartment_id' => 12,
            'start_date' => '2026-02-20',
            'end_date' => '2026-02-23',
            'status' => 'approved',
        ]);
        Booking::create([
            'tenant_id' => 6,
            'apartment_id' => 3,
            'start_date' => '2026-03-20',
            'end_date' => '2026-03-23',
            'status' => 'approved',
        ]);
        
    }
}