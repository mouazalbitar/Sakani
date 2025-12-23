<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Apartment::create([
            'owner_id' => 2, // 4 5 8
            'governorate' => 'Syria',
            'city_id' => 1,
            'street' => 'Abo Romana',
            'price' => 25,
            'rooms' => 3,
            'size' => 90,
            'condition' => 'deluxe',
            'img1'=>'ApartmentsPhoto/apart1.jpg',
            'img2'=>'ApartmentsPhoto/apart1.jpg',
            'img3'=>'ApartmentsPhoto/apart1.jpg'
        ]);
        Apartment::create([
            'owner_id' => 2, // 4 5 8
            'governorate' => 'Syria',
            'city_id' => 1,
            'street' => 'Malki',
            'price' => 18,
            'rooms' => 1,
            'size' => 40,
            'condition' => 'deluxe',
            'img1'=>'ApartmentsPhoto/apart2.jpg',
            'img2'=>'ApartmentsPhoto/apart2.jpg',
            'img3'=>'ApartmentsPhoto/apart2.jpg'
        ]);
        Apartment::create([
            'owner_id' => 5, // 4 5 8
            'governorate' => 'Syria',
            'city_id' => 2,
            'street' => 'Enshaat',
            'price' => 15,
            'rooms' => 2,
            'size' => 75,
            'condition' => 'deluxe',
            'img1'=>'ApartmentsPhoto/apart3.jpg',
            'img2'=>'ApartmentsPhoto/apart3.jpg',
            'img3'=>'ApartmentsPhoto/apart3.jpg'
        ]);
        Apartment::create([
            'owner_id' => 5, // 4 5 8
            'governorate' => 'Syria',
            'city_id' => 2,
            'street' => 'Ghota',
            'price' => 20,
            'rooms' => 4,
            'size' => 110,
            'condition' => 'new',
            'img1'=>'ApartmentsPhoto/apart4.jpg',
            'img2'=>'ApartmentsPhoto/apart4.jpg',
            'img3'=>'ApartmentsPhoto/apart4.jpg'
        ]);
        Apartment::create([
            'owner_id' => 8, // 4 5 8
            'governorate' => 'Syria',
            'city_id' => 1,
            'street' => 'Midan',
            'price' => 10,
            'rooms' => 2,
            'size' => 60,
            'condition' => 'new',
            'img1'=>'ApartmentsPhoto/apart5.jpg',
            'img2'=>'ApartmentsPhoto/apart5.jpg',
            'img3'=>'ApartmentsPhoto/apart5.jpg'
        ]);
        Apartment::create([
            'owner_id' => 4, // 4 5 8
            'governorate' => 'Syria',
            'city_id' => 4,
            'street' => 'Alzeraa',
            'price' => 12,
            'rooms' => 2,
            'size' => 60,
            'condition' => 'normal',
            'img1'=>'ApartmentsPhoto/apart6.jpg',
            'img2'=>'ApartmentsPhoto/apart6.jpg',
            'img3'=>'ApartmentsPhoto/apart6.jpg'
        ]);
        Apartment::create([
            'owner_id' => 8, // 4 5 8
            'governorate' => 'Syria',
            'city_id' => 3,
            'street' => 'Ashrafee',
            'price' => 22,
            'rooms' => 3,
            'size' => 100,
            'condition' => 'new'
        ]);
    }
}
