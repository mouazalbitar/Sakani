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
            'tenant_id' => 5,
            'rating' => 4.5
        ]);
        Review::create([
            'apartment_id' => 1,
            'tenant_id' => 3, 
            'rating' => 4
        ]);
        Review::create([
            'apartment_id' => 1,
            'tenant_id' => 4,
            'rating' => 4.8
        ]);
        Review::create([
            'apartment_id' => 1,
            'tenant_id' => 6,
            'rating' => 3.7
        ]);
        // second apartment
        Review::create([
            'apartment_id' => 2, 
            'tenant_id' => 5,
            'rating' => 4.6
        ]);
        Review::create([
            'apartment_id' => 2, 
            'tenant_id' => 3,
            'rating' => 4.4
        ]);
        Review::create([
            'apartment_id' => 2, 
            'tenant_id' => 4,
            'rating' => 4.2
        ]);
        Review::create([
            'apartment_id' => 2, 
            'tenant_id' => 6,
            'rating' => 3.5
        ]);
        // third apartment
        Review::create([
            'apartment_id' => 3, 
            'tenant_id' => 6,
            'rating' => 4.8
        ]);
        Review::create([
            'apartment_id' => 3, 
            'tenant_id' => 4,
            'rating' => 4
        ]);
        Review::create([
            'apartment_id' => 3, 
            'tenant_id' => 1,
            'rating' => 3.7
        ]);
    }
}
