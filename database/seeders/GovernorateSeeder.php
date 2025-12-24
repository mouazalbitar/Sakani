<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $governorates = [
            'Damascus',
            'Damascus Countryside',
            'Homs',
            'Aleppo',
            // 'Hama',
            // 'Latakia',
            // 'Tartus',
            // 'Idlib',
            // 'Daraa',
        ];
        foreach ($governorates as $governorate) {
            Governorate::create([
                'governorate' => $governorate
            ]);
        }
    }
}
