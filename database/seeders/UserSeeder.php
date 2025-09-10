<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password123'),
        ]);

        // You can add more users if needed
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'password' => Hash::make('password123'),
        ]);
        User::create([
            'name' => 'Dhemit Admin',
            'email' => 'dhemit@ticketify.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
