<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $damascusCities = [
            'Midan',
            'Mazzeh',
            'KafarSouseh',
            'AboRimaneh',
            'Mallkie',
            'Shagour'
        ];
        foreach ($damascusCities as $city) {
            City::create([
                'govId' => 1,
                'city' => $city
            ]);
        }

        $rifDamascusCities = [
            'Zabadani',
            'Daraya',
            'Qara',
            'Dmeer',
            'Bakeen',
            'Yabrod'
        ];
        foreach ($rifDamascusCities as $city) {
            City::create([
                'govId' => 2,
                'city' => $city
            ]);
        }

        $homsCities = [
            'Al_Qusayr',
            'Rastan',
            'Tadmur',
            'Al_Houla',
            'Al_Hamidiyah',
            'Al_Enshaate',
            'Al_Waeer'
        ];
        foreach ($homsCities as $city) {
            City::create([
                'govId' => 3,
                'city' => $city
            ]);
        }

        $allepoCities = [
            'Al_Ashrafee',
            'Al_Shahbaa',
            'Al-Bab',
            'Jarabulus',
        ];
        foreach ($allepoCities as $city) {
            City::create([
                'govId' => 4,
                'city' => $city
            ]);
        }
    }
}
