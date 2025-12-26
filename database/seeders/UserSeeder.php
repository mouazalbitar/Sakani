<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'phone_number' => '0965050015',
            'password' => Hash::make('mouaz123'),
            'firstName' => 'Mouaz',
            'lastName' => 'Albitar',
            'email' => 'mouazalbitar@gmail.com',
            'type' => 1,
            'city_id' => 1,
            'birthday' => '2000-01-01',
            'is_approved' => 'approved',
            'photo'=>'UsersPhoto/mouaz1.jpg',
            'id_img'=>'UsersIdPhoto/mouazid.jpg'
        ]);
        User::create([
            'phone_number' => '0987654321',
            'password' => Hash::make('ba123'),
            'firstName' => 'Bayan',
            'lastName' => 'Alhoure',
            'email' => 'bayan@gmail.com',
            'type' => 1,
            'city_id' => 5,
            'birthday' => '2000-01-01',
            'is_approved' => 'approved',
            'photo'=>'UsersPhoto/bayan1.jpg',
            'id_img'=>'UsersIdPhoto/bayanid.jpg'
        ]);
        User::create([
            'phone_number' => '0965050001',
            'password' => Hash::make('mouaz123'),
            'firstName' => 'Ahmad',
            'lastName' => 'Albitar',
            'email' => 'ahm@gmail.com',
            'city_id' => 8,
            'birthday' => '2000-01-01',
            'is_approved' => 'approved',
            'photo'=>'UsersPhoto/photo2.jpg',
            'id_img'=>'UsersIdPhoto/id2.jpg'
        ]);
        User::create([
            'phone_number' => '0965050002',
            'password' => Hash::make('mouaz123'),
            'firstName' => 'Nour',
            'lastName' => 'Taibah',
            'email' => 'nor@gmail.com',
            'city_id' => 20,
            'birthday' => '2000-01-01',
            'is_approved' => 'approved',
            'photo'=>'UsersPhoto/photo3.jpg',
            'id_img'=>'UsersIdPhoto/id3.jpg'
        ]);
        User::create([
            'phone_number' => '0965050003',
            'password' => Hash::make('mouaz123'),
            'firstName' => 'Samer',
            'lastName' => 'Almasre',
            'email' => 'sam@gmail.com',
            'city_id' => 18,
            'birthday' => '2000-01-01',
            'is_approved' => 'approved',
            'photo'=>'UsersPhoto/photo4.jpg',
            'id_img'=>'UsersIdPhoto/id4.jpg'
        ]);
        User::create([
            'phone_number' => '0965050004',
            'password' => Hash::make('mouaz123'),
            'firstName' => 'Sara',
            'lastName' => 'Sadek',
            'email' => 'sar@gmail.com',
            'city_id' => 15,
            'birthday' => '2000-01-01'
        ]);
        User::create([
            'phone_number' => '0965050005',
            'password' => Hash::make('mouaz123'),
            'firstName' => 'Samer',
            'lastName' => 'Samer',
            'email' => 'sam@gmail.com',
            'city_id' => 10,
            'birthday' => '2000-01-01'
        ]);
        User::create([
            'phone_number' => '0965050006',
            'password' => Hash::make('mouaz123'),
            'firstName' => 'Abd',
            'lastName' => 'Tinawe',
            'email' => 'abd@gmail.com',
            'city_id' => 22,
            'birthday' => '2000-01-01',
            'is_approved' => 'approved',
        ]);
        User::create([
            'phone_number' => '0965050007',
            'password' => Hash::make('mouaz123'),
            'firstName' => 'Salam',
            'lastName' => 'Ghrout',
            'email' => 'sam@gmail.com',
            'city_id' => 2,
            'birthday' => '2000-01-01',
            'is_approved' => 'rejected'
        ]);
        User::create([
            'phone_number' => '0965050008',
            'password' => Hash::make('mouaz123'),
            'firstName' => 'Farah',
            'lastName' => 'Khito',
            'email' => 'farah@gmail.com',
            'city_id' => 11,
            'birthday' => '2000-01-01'
        ]);
    }
}
