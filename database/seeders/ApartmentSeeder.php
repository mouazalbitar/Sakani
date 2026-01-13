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
            'images' => [
                'ApartmentsPhoto/apart1.jpg',
                'ApartmentsPhoto/apart9.jpg',
                'ApartmentsPhoto/apart5.jpg',
                'ApartmentsPhoto/apart4.jpg',
                'ApartmentsPhoto/apart6.jpg'
            ]
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
            'images' => [
                'ApartmentsPhoto/apart2.jpg',
                'ApartmentsPhoto/apart4.jpg',
                'ApartmentsPhoto/apart1.jpg',
                'ApartmentsPhoto/apart4.jpg',
                'ApartmentsPhoto/apart6.jpg'
            ]
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
            'images' => [
                'ApartmentsPhoto/apart3.jpg',
                'ApartmentsPhoto/apart4.jpg',
                'ApartmentsPhoto/apart1.jpg'
            ]
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
            'images' => [
                'ApartmentsPhoto/apart4.jpg',
                'ApartmentsPhoto/apart6.jpg',
                'ApartmentsPhoto/apart8.jpg'
            ]
        ]);
        Apartment::create([
            'owner_id' => 8, // 4 5 8
            'governorate_id' => 3,
            'city_id' => 15,
            'price' => 10,
            'rooms' => 2,
            'size' => 60,
            'condition' => 'new',
            'images' => [
                'ApartmentsPhoto/apart5.jpg',
                'ApartmentsPhoto/apart9.jpg',
                'ApartmentsPhoto/apart4.jpg'
            ]
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
            'images' => [
                'ApartmentsPhoto/apart6.jpg',
                'ApartmentsPhoto/apart11.jpg',
                'ApartmentsPhoto/apart10.jpg'
            ]
        ]);
        Apartment::create([
            'owner_id' => 8, // 4 5 8
            'governorate_id' => 1,
            'city_id' => 3,
            'price' => 22,
            'rooms' => 3,
            'size' => 100,
            'condition' => 'new',
            'images' => [
                'ApartmentsPhoto/apart7.jpg',
                'ApartmentsPhoto/apart9.jpg',
                'ApartmentsPhoto/apart8.jpg'
            ]
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
            'images' => [
                'ApartmentsPhoto/apart8.jpg',
                'ApartmentsPhoto/apart9.jpg',
                'ApartmentsPhoto/apart11.jpg'
            ]
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
            'images' => [
                'ApartmentsPhoto/apart9.jpg',
                'ApartmentsPhoto/apart9.jpg',
                'ApartmentsPhoto/apart10.jpg'
            ]
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
            'images' => [
                'ApartmentsPhoto/apart3.jpg',
                'ApartmentsPhoto/apart5.jpg',
                'ApartmentsPhoto/apart8.jpg'
            ]
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
            'images' => [
                'ApartmentsPhoto/apart2.jpg',
                'ApartmentsPhoto/apart4.jpg',
                'ApartmentsPhoto/apart10.jpg',
                'ApartmentsPhoto/apart11.jpg'
            ]
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
            'images' => [
                'ApartmentsPhoto/apart8.jpg',
                'ApartmentsPhoto/apart9.jpg',
                'ApartmentsPhoto/apart11.jpg',
                'ApartmentsPhoto/apart10.jpg'
            ]
        ]);
    }
}