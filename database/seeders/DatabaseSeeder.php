<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Storage::disk('public')->deleteDirectory('UsersPhoto');
        Storage::disk('public')->makeDirectory('UsersPhoto');
        Storage::disk('public')->deleteDirectory('UsersIdPhoto');
        Storage::disk('public')->makeDirectory('UsersIdPhoto');
        Storage::disk('public')->deleteDirectory('ApartmentsPhoto');
        Storage::disk('public')->makeDirectory('ApartmentsPhoto');

        $this->call([
            CitySeeder::class,
            UserSeeder::class,
            ApartmentSeeder::class,
            // ReviweSeeder::class
        ]);
    }
}
