<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviweSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // first apartment  // avoid 4 5 8 2
        Review::create([
            'apartment_id' => 1,
            'tenant_id' => 3,
            'rating' => 4.5
        ]);
        Review::create([
            'apartment_id' => 1,
            'tenant_id' => 1,
            'rating' => 4
        ]);
        Review::create([
            'apartment_id' => 1,
            'tenant_id' => 6,
            'rating' => 3.5
        ]);
        Review::create([
            'apartment_id' => 1,
            'tenant_id' => 7,
            'rating' => 4.8
        ]);
        Review::create([
            'apartment_id' => 1,
            'tenant_id' => 9,
            'rating' => 4.9
        ]);
        Review::create([
            'apartment_id' => 1,
            'tenant_id' => 10,
            'rating' => 2.5
        ]);
        Review::create([
            'apartment_id' => 1,
            'tenant_id' => 12,
            'rating' => 3
        ]);

        // second apartment
        Review::create([
            'apartment_id' => 2,
            'tenant_id' => 3,
            'rating' => 4
        ]);
        Review::create([
            'apartment_id' => 2,
            'tenant_id' => 1,
            'rating' => 4.1
        ]);
        Review::create([
            'apartment_id' => 2,
            'tenant_id' => 6,
            'rating' => 3
        ]);
        Review::create([
            'apartment_id' => 2,
            'tenant_id' => 7,
            'rating' => 3.8
        ]);
        Review::create([
            'apartment_id' => 2,
            'tenant_id' => 9,
            'rating' => 4.9
        ]);
        Review::create([
            'apartment_id' => 2,
            'tenant_id' => 10,
            'rating' => 2.5
        ]);
        Review::create([
            'apartment_id' => 2,
            'tenant_id' => 12,
            'rating' => 4
        ]);
    }
}
