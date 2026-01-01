<?php

namespace Database\Seeders;

use App\Models\Favorite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Favorite::create([
            'apartment_id' => 1,
            'user_id' => 6
        ]);
        Favorite::create([
            'apartment_id' => 3,
            'user_id' => 6
        ]);
        Favorite::create([
            'apartment_id' => 8,
            'user_id' => 6
        ]);
        Favorite::create([
            'apartment_id' => 10,
            'user_id' => 6
        ]);
        Favorite::create([
            'apartment_id' => 1,
            'user_id' => 4
        ]);
        Favorite::create([
            'apartment_id' => 2,
            'user_id' => 4
        ]);
        Favorite::create([
            'apartment_id' => 3,
            'user_id' => 4
        ]);
    }
}