<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Superadmin
        $superadmin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $superadmin->assignRole('Superadmin');

        // 2. JalanRasa
        $jalanrasa = User::firstOrCreate(
            ['email' => 'jalanrasa@gmail.com'],
            [
                'name' => 'User JalanRasa',
                'password' => Hash::make('password'),
            ]
        );
        $jalanrasa->assignRole('JalanRasa');

        // 3. Arnes
        $arnes = User::firstOrCreate(
            ['email' => 'arnes@gmail.com'],
            [
                'name' => 'User Arnes',
                'password' => Hash::make('password'),
            ]
        );
        $arnes->assignRole('Arnes');
    }
}
