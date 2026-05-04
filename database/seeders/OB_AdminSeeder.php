<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OB_AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@eventplanner.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'profile_image' => null,
            'phone' => null,
        ]);
    }
}
