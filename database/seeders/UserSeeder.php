<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin MountainTrip',
            'email'    => 'admin@mountaintrip.id',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        // User Demo
        User::create([
            'name'     => 'Ambatukam',
            'email'    => 'user@mountaintrip.id',
            'password' => Hash::make('password123'),
            'role'     => 'user',
        ]);
    }
}