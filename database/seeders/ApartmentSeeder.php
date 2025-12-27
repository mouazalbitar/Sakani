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
            'governorate_id' => 1,
            'city_id' => 1,
            'price' => 25,
            'rooms' => 3,
            'size' => 90,
            'condition' => 'deluxe',
            'is_approved' => 'approved',
            'img1_path' => 'ApartmentsPhoto/apart1.jpg',
            'img2_path' => 'ApartmentsPhoto/apart1.jpg',
            'img3_path' => 'ApartmentsPhoto/apart1.jpg'
        ]);
        Apartment::create([
            'owner_id' => 2, // 4 5 8
            'governorate_id' => 2,
            'city_id' => 9,
            'price' => 18,
            'rooms' => 1,
            'size' => 40,
            'condition' => 'deluxe',
            'is_approved' => 'approved',
            'img1_path' => 'ApartmentsPhoto/apart2.jpg',
            'img2_path' => 'ApartmentsPhoto/apart2.jpg',
            'img3_path' => 'ApartmentsPhoto/apart2.jpg'
        ]);
        Apartment::create([
            'owner_id' => 5, // 4 5 8
            'governorate_id' => 1,
            'city_id' => 5,
            'price' => 15,
            'rooms' => 2,
            'size' => 75,
            'condition' => 'deluxe',
            'is_approved' => 'approved',
            'img1_path' => 'ApartmentsPhoto/apart3.jpg',
            'img2_path' => 'ApartmentsPhoto/apart3.jpg',
            'img3_path' => 'ApartmentsPhoto/apart3.jpg'
        ]);
        Apartment::create([
            'owner_id' => 5, // 4 5 8
            'governorate_id' => 3,
            'city_id' => 18,
            'price' => 20,
            'rooms' => 4,
            'size' => 110,
            'condition' => 'new',
            'is_approved' => 'approved',
            'img1_path' => 'ApartmentsPhoto/apart4.jpg',
            'img2_path' => 'ApartmentsPhoto/apart4.jpg',
            'img3_path' => 'ApartmentsPhoto/apart4.jpg'
        ]);
        Apartment::create([
            'owner_id' => 8, // 4 5 8
            'governorate_id' => 3,
            'city_id' => 15,
            'price' => 10,
            'rooms' => 2,
            'size' => 60,
            'condition' => 'new',
            'img1_path' => 'ApartmentsPhoto/apart5.jpg',
            'img2_path' => 'ApartmentsPhoto/apart5.jpg',
            'img3_path' => 'ApartmentsPhoto/apart5.jpg'
        ]);
        Apartment::create([
            'owner_id' => 4, // 4 5 8
            'governorate_id' => 4,
            'city_id' => 20,
            'price' => 12,
            'rooms' => 2,
            'size' => 60,
            'condition' => 'normal',
            'is_approved' => 'rejected',
            'img1_path' => 'ApartmentsPhoto/apart6.jpg',
            'img2_path' => 'ApartmentsPhoto/apart6.jpg',
            'img3_path' => 'ApartmentsPhoto/apart6.jpg'
        ]);
        Apartment::create([
            'owner_id' => 8, // 4 5 8
            'governorate_id' => 1,
            'city_id' => 3,
            'price' => 22,
            'rooms' => 3,
            'size' => 100,
            'condition' => 'new',
            'img1_path' => 'ApartmentsPhoto/apart7.jpg',
            'img2_path' => 'ApartmentsPhoto/apart7.jpg',
            'img3_path' => 'ApartmentsPhoto/apart7.jpg'
        ]);
        Apartment::create([
            'owner_id' => 5, // 4 5 8
            'governorate_id' => 2,
            'city_id' => 7,
            'price' => 20,
            'rooms' => 4,
            'size' => 100,
            'condition' => 'deluxe',
            'is_approved' => 'approved',
            'img1_path' => 'ApartmentsPhoto/apart7.jpg',
            'img2_path' => 'ApartmentsPhoto/apart7.jpg',
            'img3_path' => 'ApartmentsPhoto/apart7.jpg'
        ]);
        Apartment::create([
            'owner_id' => 4, // 4 5 8
            'governorate_id' => 4,
            'city_id' => 22,
            'price' => 15,
            'rooms' => 2,
            'size' => 110,
            'condition' => 'normal',
            'is_approved' => 'rejected',
            'img1_path' => 'ApartmentsPhoto/apart8.jpg',
            'img2_path' => 'ApartmentsPhoto/apart8.jpg',
            'img3_path' => 'ApartmentsPhoto/apart8.jpg'
        ]);
        Apartment::create([
            'owner_id' => 4, // 4 5 8
            'governorate_id' => 3,
            'city_id' => 17,
            'price' => 25,
            'rooms' => 6,
            'size' => 150,
            'condition' => 'deluxe',
            'is_approved' => 'approved',
            'img1_path' => 'ApartmentsPhoto/apart9.jpg',
            'img2_path' => 'ApartmentsPhoto/apart9.jpg',
            'img3_path' => 'ApartmentsPhoto/apart9.jpg'
        ]);
        Apartment::create([
            'owner_id' => 4, // 4 5 8
            'governorate_id' => 3,
            'city_id' => 19,
            'price' => 15,
            'rooms' => 5,
            'size' => 150,
            'condition' => 'new',
            'is_approved' => 'approved',
            'img1_path' => 'ApartmentsPhoto/apart10.jpg',
            'img2_path' => 'ApartmentsPhoto/apart10.jpg',
            'img3_path' => 'ApartmentsPhoto/apart10.jpg'
        ]);
        Apartment::create([
            'owner_id' => 5, // 4 5 8
            'governorate_id' => 1,
            'city_id' => 4,
            'price' => 23,
            'rooms' => 2,
            'size' => 85,
            'condition' => 'normal',
            'is_approved' => 'approved',
            'img1_path' => 'ApartmentsPhoto/apart11.jpg',
            'img2_path' => 'ApartmentsPhoto/apart11.jpg',
            'img3_path' => 'ApartmentsPhoto/apart11.jpg'
        ]);
    }
}