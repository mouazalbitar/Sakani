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
        // User::create([
        //     'phone_number' => '0965050015',
        //     'password' => Hash::make('Mouaz#123'),
        //     'firstName' => 'Mouaz',
        //     'lastName' => 'Albitar',
        //     'email' => 'mouazalbitar@gmail.com',
        //     'city_id' => 1,
        //     'birthday'=>'2000-01-01'
        // ]);
        User::create([
            'phone_number' => '0965050001',
            'password' => Hash::make('Mouaz#123'),
            'firstName' => 'Ahmad',
            'lastName' => 'Albitar',
            'email' => 'ahm@gmail.com',
            'city_id' => 1,
            'birthday'=>'2000-01-01'
        ]);
        User::create([
            'phone_number' => '0965050002',
            'password' => Hash::make('Mouaz#123'),
            'firstName' => 'Nour',
            'lastName' => 'Taibah',
            'email' => 'nor@gmail.com',
            'city_id' => 2,
            'birthday'=>'2000-01-01'
        ]);
        User::create([
            'phone_number' => '0965050003',
            'password' => Hash::make('Mouaz#123'),
            'firstName' => 'Samer',
            'lastName' => 'Almasre',
            'email' => 'sam@gmail.com',
            'city_id' => 4,
            'birthday'=>'2000-01-01'
        ]);
        User::create([
            'phone_number' => '0965050004',
            'password' => Hash::make('Mouaz#123'),
            'firstName' => 'Sara',
            'lastName' => 'Sadek',
            'email' => 'sar@gmail.com',
            'city_id' => 2,
            'birthday'=>'2000-01-01'
        ]);
        User::create([
            'phone_number' => '0965050005',
            'password' => Hash::make('Mouaz#123'),
            'firstName' => 'Lana',
            'lastName' => 'Deep',
            'email' => 'lana@gmail.com',
            'city_id' => 1,
            'birthday'=>'2000-01-01'
        ]);
        User::create([
            'phone_number' => '0965050006',
            'password' => Hash::make('Mouaz#123'),
            'firstName' => 'Mohamad',
            'lastName' => 'Attar',
            'email' => 'moh@gmail.com',
            'city_id' => 3,
            'birthday'=>'2000-01-01'
        ]);
        User::create([
            'phone_number' => '0965050007',
            'password' => Hash::make('Mouaz#123'),
            'firstName' => 'Qusay',
            'lastName' => 'Hamad',
            'email' => 'qos@gmail.com',
            'city_id' => 1,
            'birthday'=>'2000-01-01'
        ]);
        User::create([
            'phone_number' => '0965050008',
            'password' => Hash::make('Mouaz#123'),
            'firstName' => 'Ahmad',
            'lastName' => 'Saeed',
            'email' => 'ahmm@gmail.com',
            'city_id' => 5,
            'birthday'=>'2000-01-01'
        ]);
        User::create([
            'phone_number' => '0965050009',
            'password' => Hash::make('Mouaz#123'),
            'firstName' => 'Abd',
            'lastName' => 'bitar',
            'email' => 'abd@gmail.com',
            'city_id' => 5,
            'birthday'=>'2000-01-01'
        ]);
    }
}
